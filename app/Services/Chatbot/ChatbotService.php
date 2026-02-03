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
        $apiKey = config('services.openai.key') ?? env('OPENAI_API_KEY');

        if (empty($apiKey)) {
            Log::critical('OpenAI API Key is missing.');
            throw new \Exception('OpenAI API Key não configurada.');
        }

        // Configuração blindada para Localhost (SSL)
        $this->client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withHttpClient(new GuzzleClient([
                'verify' => false, 
                'timeout' => 30,
            ]))
            ->make();
    }

    public function handleMessage(string $message, string $locale, array $history = []): array
    {
        $tools = $this->getToolsDefinition();
        
        $systemPrompt = "You are 'Crow AI', the real estate assistant for Crow Global.
            Current Language: '{$locale}'.
            RULES:
            1. Answer exclusively in '{$locale}'.
            2. Be concise and professional.
            3. Use 'search_properties' for buying.
            4. Use 'submit_sell_lead' for selling.
            5. Use 'request_off_market_access' ONLY if user asks for exclusive/off-market access.
        ";

        $cleanHistory = array_map(function($msg) {
            return ['role' => $msg['role'], 'content' => $msg['content'] ?? ''];
        }, $history);

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $cleanHistory,
            [['role' => 'user', 'content' => $message]]
        );

        try {
            // Chamada à API (Modelo Econômico)
            $response = $this->client->chat()->create([
                'model' => 'gpt-4o-mini', 
                'messages' => $messages,
                'tools' => $tools,
                'tool_choice' => 'auto', 
            ]);

            $choice = $response->choices[0];
            $replyContent = $choice->message->content ?? '';
            $frontendData = null;

            if ($choice->finishReason === 'tool_calls') {
                $messages[] = $choice->message->toArray();

                foreach ($choice->message->toolCalls as $toolCall) {
                    $functionName = $toolCall->function->name;
                    $args = json_decode($toolCall->function->arguments, true);

                    $toolResult = $this->executeFunction($functionName, $args);

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

                $finalResponse = $this->client->chat()->create([
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages,
                ]);

                $replyContent = $finalResponse->choices[0]->message->content;
            }

            if (empty($replyContent)) $replyContent = "Ok.";
            $audioBase64 = $this->textToSpeech($replyContent);

            return [
                'reply' => $replyContent,
                'audio' => $audioBase64,
                'data'  => $frontendData
            ];

        } catch (\Exception $e) {
            Log::error("Chatbot Error: " . $e->getMessage());
            return [
                'reply' => ($locale == 'pt') ? "Tive um erro técnico momentâneo. Tente novamente." : "Temporary technical error.",
                'audio' => null,
                'data' => null
            ];
        }
    }

    private function textToSpeech(string $text): ?string
    {
        try {
            $textSample = substr($text, 0, 500); 
            $response = $this->client->audio()->speech([
                'model' => 'tts-1', 
                'input' => $textSample,
                'voice' => 'shimmer', 
            ]);
            return base64_encode($response); 
        } catch (\Exception $e) {
            Log::error('TTS Error: ' . $e->getMessage());
            return null; 
        }
    }

    private function executeFunction(string $name, array $args)
    {
        try {
            switch ($name) {
                case 'search_properties':
                    $query = Property::query()
                        ->where('status', 'active')
                        ->where('is_exclusive', false);

                    if (!empty($args['city'])) $query->where('city', 'LIKE', "%{$args['city']}%");
                    
                    if (!empty($args['max_price'])) {
                        $price = preg_replace('/[^0-9]/', '', $args['max_price']);
                        $query->where('price', '<=', $price);
                    }

                    $properties = $query->limit(4)->get();

                    if ($properties->isEmpty()) return "No properties found.";

                    return [
                        'summary' => "Found " . $properties->count() . " properties.",
                        'data' => $properties->map(function($p) {
                            return [
                                'id' => $p->id,
                                'title' => $p->title ?? 'Imóvel',
                                'price' => number_format($p->price, 0, ',', '.') . ' €',
                                'image' => $p->cover_image ? asset('storage/' . $p->cover_image) : 'https://placehold.co/600x400',
                                'link' => route('properties.show', $p->id)
                            ];
                        })
                    ];

                case 'submit_sell_lead':
                    try {
                        Mail::raw("Nova Lead de Venda (AI Chatbot):\n\nDescrição: {$args['description']}\nContato: {$args['contact']}", function ($msg) {
                            $msg->to('admin@crow-global.com') // Troque pelo seu email real de teste
                                ->subject('Nova Oportunidade de Venda 🏠');
                        });
                        Log::info("Lead email sent.");
                    } catch (\Exception $e) {
                        Log::error("Mail Error: " . $e->getMessage());
                    }
                    return "Lead saved and admin notified.";

                case 'request_off_market_access':
                    // Verificação extra para evitar duplicidade de email (Opcional, mas boa prática)
                    if (AccessRequest::where('email', $args['email'])->exists()) {
                        return "Este e-mail já possui uma solicitação pendente.";
                    }

                    AccessRequest::create([
                        'user_id' => auth()->id() ?? null,
                        'name' => $args['name'],
                        'email' => $args['email'],
                        'message' => $args['reason'], 
                        'status' => 'pending',
                        'requested_role' => 'investor', 
                        'country' => 'Portugal', // Obrigatório no banco
                        'investor_type' => 'client' // <--- CORREÇÃO: Valor aceito pelo ENUM do banco
                    ]);
                    
                    return "Request submitted successfully. Waiting for approval.";

                default:
                    return "Function not found.";
            }
        } catch (\Exception $e) {
            Log::error("DB Error ($name): " . $e->getMessage());
            return "Error executing action: " . $e->getMessage();
        }
    }

    private function getToolsDefinition(): array
    {
        return [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'search_properties',
                    'description' => 'Search properties for sale.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'city' => ['type' => 'string'],
                            'max_price' => ['type' => 'number'],
                        ],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'submit_sell_lead',
                    'description' => 'User wants to sell a property.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'description' => ['type' => 'string'],
                            'contact' => ['type' => 'string'],
                        ],
                        'required' => ['description', 'contact'],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'request_off_market_access',
                    'description' => 'Request exclusive access.',
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