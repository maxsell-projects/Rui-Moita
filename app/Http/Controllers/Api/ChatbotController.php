<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Chatbot\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected ChatbotService $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array', // O seu JS envia o histórico (slice(-6))
        ]);

        try {
            // O Service deve retornar um array estruturado, não apenas uma string
            // Exemplo de retorno do Service: ['text' => 'Olá...', 'properties' => [...], 'audio' => 'base64...']
            $botResponse = $this->chatbotService->handle(
                $validated['message'],
                $request->user(),
                $validated['history'] ?? []
            );

            // Resposta formatada para o SEU Frontend específico
            return response()->json([
                'status' => 'success',
                
                // O JS lê: data.reply
                'reply' => $botResponse['text'] ?? 'Desculpe, não entendi.', 
                
                // O JS lê: data.data (para os cards de imóveis)
                // Certifique-se que o array de imóveis tenha chaves: 'title', 'price', 'image', 'link'
                'data' => $botResponse['properties'] ?? [], 
                
                // O JS lê: data.audio (para o player de voz)
                'audio' => $botResponse['audio'] ?? null, 
            ], 200);

        } catch (\Exception $e) {
            Log::error('Chatbot Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'reply' => 'Ocorreu um erro interno. Tente novamente.',
            ], 500);
        }
    }
}