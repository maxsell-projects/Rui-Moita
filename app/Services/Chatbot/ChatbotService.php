<?php

namespace App\Services\Chatbot;

use OpenAI;
use App\Models\Property;
use App\Models\AccessRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client as GuzzleClient;

class ChatbotService
{
    protected $client;

    public function __construct()
    {
        // 1. Em produção, use sempre config(). O env() retorna null se o config:cache estiver rodando.
        $apiKey = config('services.openai.key');

        if (empty($apiKey)) {
            Log::critical('OpenAI API Key is missing in config/services.php');
            // Não lançamos Exception para não quebrar a página do usuário, o handle tratará.
        }

        // 2. Segurança: Só desativa verificação SSL se estivermos em LOCAL
        $httpClient = new GuzzleClient([
            'verify' => app()->isLocal() ? false : true, 
            'timeout' => 30,
        ]);

        $this->client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withHttpClient($httpClient)
            ->make();
    }

    /**
     * Método principal chamado pelo Controller.
     */
    public function handle(string $message, $user = null, array $history = []): array
    {
        // Define o idioma com fallback para PT
        $locale = app()->getLocale() ?? 'pt'; 

        $tools = $this->getToolsDefinition();
        
        // 3. Prompt Atualizado para INTELLECTUS
        $systemPrompt = "You are 'Intellectus AI', the premium real estate assistant for Intellectus.
            Current Language: '{$locale}'.
            
            YOUR PERSONA:
            - You are sophisticated, professional, and helpful.
            - You specialize in the Portuguese market and exclusive 'Off-Market' opportunities.
            
            RULES:
            1. Answer exclusively in '{$locale}'.
            2. Be concise but polite.
            3. Use 'search_properties' ONLY when the user explicitly asks to buy or see properties.
            4. Use 'submit_sell_lead' ONLY when the user wants to sell their property.
            5. Use 'request_off_market_access' ONLY if the user asks for 'Off-Market', 'Exclusive Access', or 'Private Collection'.
            
            FORMATTING:
            - Use bolding for key terms.
            - Do not mention you are an AI unless asked.";

        // Limpeza do histórico para economizar tokens e evitar erros de formato
        $cleanHistory = array_map(function($msg) {
            return [
                'role' => $msg['role'] ?? 'user', 
                'content' => $msg['content'] ?? ''
            ];
        }, $history);

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $cleanHistory,
            [['role' => 'user', 'content' => $message]]
        );

        try {
            if (!$this->client) throw new \Exception("OpenAI Client not initiated.");

            // Chamada à API
            $response = $this->client->chat()->create([
                'model' => 'gpt-4o-mini', 
                'messages' => $messages,
                'tools' => $tools,
                'tool_choice' => 'auto', 
            ]);

            $choice = $response->choices[0];
            $replyContent = $choice->message->content ?? '';
            $frontendData = null;

            // Se a IA decidiu chamar uma ferramenta (Função)
            if ($choice->finishReason === 'tool_calls') {
                $messages[] = $choice->message->toArray();

                foreach ($choice->message->toolCalls as $toolCall) {
                    $functionName = $toolCall->function->name;
                    $args = json_decode($toolCall->function->arguments, true);

                    // Executa a lógica interna (DB, Email, etc)
                    $toolResult = $this->executeFunction($functionName, $args, $user);

                    // Se for busca de imóveis, separamos os dados para o Frontend (Cards)
                    if ($functionName === 'search_properties' && is_array($toolResult) && isset($toolResult['data'])) {
                        $frontendData = $toolResult['data'];
                        $toolResult = $toolResult['summary']; // O texto para a IA é só o resumo
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

            if (empty($replyContent)) $replyContent = ($locale == 'pt') ? "Entendido." : "Understood.";
            
            // Gera o áudio
            $audioBase64 = $this->textToSpeech($replyContent);

            return [
                'text' => $replyContent, // O Controller espera 'text' ou 'reply' (ajuste conforme seu controller)
                'audio' => $audioBase64,
                'properties' => $frontendData // O Controller mapeia isso para 'data'
            ];

        } catch (\Exception $e) {
            Log::error("Chatbot Error: " . $e->getMessage());
            return [
                'text' => ($locale == 'pt') ? "Desculpe, estou com uma instabilidade momentânea." : "I'm experiencing a temporary issue.",
                'audio' => null,
                'properties' => null
            ];
        }
    }

    private function textToSpeech(string $text): ?string
    {
        try {
            // Limita caracteres para economizar custos e latência
            $textSample = substr(strip_tags($text), 0, 500); 
            
            $response = $this->client->audio()->speech([
                'model' => 'tts-1', 
                'input' => $textSample,
                'voice' => 'shimmer', // Voz feminina suave, combina com Intellectus
            ]);
            
            return base64_encode($response); 
        } catch (\Exception $e) {
            Log::warning('TTS Error: ' . $e->getMessage()); // Warning é melhor que Error aqui, pois não quebra o fluxo
            return null; 
        }
    }

    private function executeFunction(string $name, array $args, $user = null)
    {
        try {
            switch ($name) {
                case 'search_properties':
                    $query = Property::query()
                        ->where('status', 'active')
                        ->where('is_exclusive', false);

                    if (!empty($args['city'])) {
                        $query->where('city', 'LIKE', "%{$args['city']}%")
                              ->orWhere('title', 'LIKE', "%{$args['city']}%");
                    }
                    
                    if (!empty($args['max_price'])) {
                        $price = preg_replace('/[^0-9]/', '', $args['max_price']);
                        $query->where('price', '<=', $price);
                    }

                    // Trazemos 4 imóveis para caber bem no chat
                    $properties = $query->limit(4)->get();

                    if ($properties->isEmpty()) return "Nenhum imóvel encontrado com esses critérios.";

                    return [
                        'summary' => "Encontrei " . $properties->count() . " imóveis para você.",
                        'data' => $properties->map(function($p) {
                            return [
                                'id' => $p->id,
                                'title' => $p->title ?? 'Imóvel Premium',
                                'price' => number_format($p->price, 0, ',', '.') . ' €',
                                // Fallback de imagem robusto
                                'image' => $p->cover_image ? asset('storage/' . $p->cover_image) : asset('img/maxsell.png'),
                                'link' => route('properties.show', $p->id)
                            ];
                        })
                    ];

                case 'submit_sell_lead':
                    // Envia email de notificação
                    try {
                        Mail::raw("Nova Lead de Venda (Chatbot):\n\nDesc: {$args['description']}\nContato: {$args['contact']}", function ($msg) {
                            $msg->to(config('mail.from.address')) // Envia para o admin do sistema
                                ->subject('🔥 Nova Oportunidade de Venda (Intellectus)');
                        });
                    } catch (\Exception $e) {
                        Log::error("Mail Error: " . $e->getMessage());
                    }
                    return "Recebemos seu contato. Um consultor Intellectus ligará em breve.";

                case 'request_off_market_access':
                    if (AccessRequest::where('email', $args['email'])->exists()) {
                        return "Este e-mail já possui uma solicitação pendente.";
                    }

                    AccessRequest::create([
                        'user_id' => $user ? $user->id : null,
                        'name' => $args['name'],
                        'email' => $args['email'],
                        'message' => $args['reason'] ?? 'Solicitado via Chatbot', 
                        'status' => 'pending',
                        'requested_role' => 'investor', 
                        'country' => 'Portugal', 
                        'investor_type' => 'client' 
                    ]);
                    
                    return "Solicitação Off-Market recebida com sucesso. Nossa equipe analisará seu perfil.";

                default:
                    return "Função desconhecida.";
            }
        } catch (\Exception $e) {
            Log::error("DB Error ($name): " . $e->getMessage());
            return "Ocorreu um erro ao processar sua solicitação.";
        }
    }

    private function getToolsDefinition(): array
    {
        return [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'search_properties',
                    'description' => 'Search for properties/homes to buy.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'city' => ['type' => 'string', 'description' => 'City or location name (e.g. Lisbon, Porto)'],
                            'max_price' => ['type' => 'number', 'description' => 'Maximum budget'],
                        ],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'submit_sell_lead',
                    'description' => 'User wants to sell their property/home.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'description' => ['type' => 'string', 'description' => 'Details of the property'],
                            'contact' => ['type' => 'string', 'description' => 'Phone number or email'],
                        ],
                        'required' => ['description', 'contact'],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'request_off_market_access',
                    'description' => 'Request exclusive/off-market access.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'name' => ['type' => 'string'],
                            'email' => ['type' => 'string'],
                            'reason' => ['type' => 'string'],
                        ],
                        'required' => ['name', 'email', 'reason'],
                    ],
                ],
            ],
        ];
    }
}