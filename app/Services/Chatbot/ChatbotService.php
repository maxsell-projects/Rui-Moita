<?php

namespace App\Services\Chatbot;

use OpenAI;
use App\Models\Property;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client as GuzzleClient;

class ChatbotService
{
    protected $client;

    public function __construct()
    {
        $apiKey = config('services.openai.key') ?? env('OPENAI_API_KEY');

        if (empty($apiKey)) {
            Log::critical('OpenAI API Key is missing.');
            return; 
        }

        // Timeout 60s para garantir geração de áudio
        $this->client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withHttpClient(new GuzzleClient(['timeout' => 60])) 
            ->make();
    }

    public function handleMessage(string $message, string $locale = 'pt', array $history = []): array
    {
        if (!$this->client) {
            return [
                'reply' => 'O assistente está em manutenção momentânea.',
                'audio' => null,
                'data'  => null
            ];
        }

        $tools = $this->getToolsDefinition();
        
        // --- CONTEXTO DINÂMICO ---
        $appName = Config::get('app.name', 'Imobiliária Premium');
        
        // --- PROMPT REFINADO (GENERIC & BRANDED) ---
        // Agora ele assume a postura da nova marca (Bordeaux/Verde)
        $systemPrompt = "
            You are the 'Private Virtual Assistant' for {$appName}, a high-end real estate agency.
            
            CONTEXT & BRANDING:
            - Brand Identity: Exclusive, Heritage, Trust.
            - Visual Tone: Bordeaux (Passion/Luxury) and English Green (Tradition/Nature).
            - Your Tone: Professional, Executive, Discreet, and Expert.
            
            CRITICAL LANGUAGE INSTRUCTION:
            You MUST speak in EUROPEAN PORTUGUESE (Português de Portugal).
            - Use 'estou a fazer' instead of 'estou fazendo'.
            - Use 'connosco' instead of 'conosco'.
            - Use 'gostaria' instead of 'queria'.
            - Treat the user with high formality (implicitly 'O senhor/A senhora').
            - Avoid the word 'você' explicitly; use third-person conjugation.
            
            RULES:
            1. Answer exclusively in European Portuguese.
            2. Be concise but sophisticated. High-net-worth clients value time.
            3. Use 'search_properties' ONLY when the user asks for properties, houses, or investment opportunities.
            4. Use 'schedule_meeting' if the user wants to sell, talk to an agent, or schedule a visit.
            5. Do not invent property data. Only use what the tool returns.
        ";

        // Limpar histórico (mantém apenas as últimas 6 mensagens para economizar tokens)
        $cleanHistory = array_map(function($msg) {
            return ['role' => $msg['role'], 'content' => $msg['content'] ?? ''];
        }, array_slice($history, -6)); 

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $cleanHistory,
            [['role' => 'user', 'content' => $message]]
        );

        try {
            $response = $this->client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'tools' => $tools,
                'tool_choice' => 'auto', 
            ]);

            $choice = $response->choices[0];
            $replyContent = $choice->message->content ?? '';
            $frontendData = null;

            // Se a IA decidiu chamar uma ferramenta (busca ou agendamento)
            if ($choice->finishReason === 'tool_calls') {
                $messages[] = $choice->message->toArray();

                foreach ($choice->message->toolCalls as $toolCall) {
                    $functionName = $toolCall->function->name;
                    $args = json_decode($toolCall->function->arguments, true);

                    $toolResult = $this->executeFunction($functionName, $args);

                    // Se for busca, separamos os dados para o Frontend (Cards) do resumo em texto
                    if ($functionName === 'search_properties' && is_array($toolResult) && isset($toolResult['data'])) {
                        $frontendData = $toolResult['data'];
                        $toolResult = $toolResult['summary'];
                    }

                    $messages[] = [
                        'role' => 'tool',
                        'tool_call_id' => $toolCall->id,
                        'content' => is_string($toolResult) ? $toolResult : json_encode($toolResult)
                    ];
                }

                // Segunda chamada para a IA gerar a resposta final com base no resultado da ferramenta
                $finalResponse = $this->client->chat()->create([
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages,
                ]);

                $replyContent = $finalResponse->choices[0]->message->content;
            }

            if (empty($replyContent)) $replyContent = "Compreendido. Posso ajudar com algo mais?";
            
            // --- GERAÇÃO DE ÁUDIO (TTS) ---
            $audioBase64 = $this->textToSpeech($replyContent);

            return [
                'reply' => $replyContent,
                'audio' => $audioBase64,
                'data'  => $frontendData
            ];

        } catch (\Exception $e) {
            Log::error("Chatbot Error: " . $e->getMessage());
            return [
                'reply' => "Peço desculpa, mas estou com uma ligeira instabilidade na ligação. Pode repetir?",
                'audio' => null,
                'data' => null
            ];
        }
    }

    private function textToSpeech(string $text): ?string
    {
        try {
            // Limite de caracteres para segurança da API
            $inputText = mb_substr($text, 0, 4096);

            $response = $this->client->audio()->speech([
                'model' => 'tts-1',
                'input' => $inputText,
                'voice' => 'onyx', // Voz "Onyx" é a mais neutra/profissional
                'response_format' => 'mp3',
                'speed' => 1.0
            ]);

            return base64_encode($response); 

        } catch (\Exception $e) {
            Log::error("Chatbot TTS Error: " . $e->getMessage());
            return null;
        }
    }

    private function executeFunction(string $name, array $args)
    {
        try {
            switch ($name) {
                case 'search_properties':
                    $query = Property::query()
                        ->where('is_visible', true);
                        // ->where('status', '!=', 'Sold') // Ativar se necessário

                    if (!empty($args['location'])) {
                        $query->where(function($q) use ($args) {
                            $q->where('location', 'LIKE', "%{$args['location']}%")
                              ->orWhere('city', 'LIKE', "%{$args['location']}%")
                              ->orWhere('title', 'LIKE', "%{$args['location']}%");
                        });
                    }
                    
                    if (!empty($args['type'])) {
                        $query->where('type', 'LIKE', "%{$args['type']}%");
                    }

                    if (!empty($args['max_price'])) {
                        $price = preg_replace('/[^0-9]/', '', $args['max_price']);
                        $query->where('price', '<=', $price);
                    }

                    $properties = $query->latest()->limit(3)->get();

                    if ($properties->isEmpty()) return "Não encontrei imóveis com esses critérios exatos no nosso portfólio privado.";

                    return [
                        'summary' => "Encontrei " . $properties->count() . " opções exclusivas.",
                        'data' => $properties->map(function($p) {
                            return [
                                'id' => $p->id,
                                'title' => $p->title,
                                'price' => number_format($p->price, 0, ',', '.') . ' €',
                                // Garante fallback de imagem se não houver capa
                                'image' => $p->cover_image ? asset('storage/' . $p->cover_image) : 'https://placehold.co/600x400?text=Sem+Imagem',
                                'link' => route('properties.show', $p->slug)
                            ];
                        })
                    ];

                case 'schedule_meeting':
                    try {
                        $contact = $args['contact'] ?? 'Não informado';
                        $reason = $args['reason'] ?? 'Geral';
                        Log::info("Lead Chatbot Capturado: [{$contact}] - Motivo: {$reason}");
                        
                        // TODO: Disparar Evento ou Job para envio de email assíncrono
                        // ContactLeadJob::dispatch($contact, $reason);

                    } catch (\Exception $e) {
                        Log::error("Mail/Log Error: " . $e->getMessage());
                    }
                    return "O pedido de agendamento foi registado com sucesso. A nossa equipa entrará em contacto brevemente.";

                default:
                    return "Função desconhecida.";
            }
        } catch (\Exception $e) {
            return "Erro ao processar pedido: " . $e->getMessage();
        }
    }

    private function getToolsDefinition(): array
    {
        return [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'search_properties',
                    'description' => 'Procurar imóveis para venda ou investimento com base em critérios.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'location' => ['type' => 'string', 'description' => 'Cidade ou zona (ex: Lisboa, Cascais)'],
                            'type' => ['type' => 'string', 'description' => 'Tipo de imóvel (Apartamento, Moradia, Terreno)'],
                            'max_price' => ['type' => 'number', 'description' => 'Preço máximo ou orçamento em euros'],
                        ],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'schedule_meeting',
                    'description' => 'Agendar reunião, visita ou pedir contacto comercial.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'contact' => ['type' => 'string', 'description' => 'Email ou telefone do utilizador'],
                            'reason' => ['type' => 'string', 'description' => 'Motivo do contacto (Vender, Comprar, Visita)'],
                        ],
                        'required' => ['contact'],
                    ],
                ],
            ],
        ];
    }
}