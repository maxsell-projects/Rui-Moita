<?php

namespace App\Http\Controllers\Api; // <--- OBRIGATÓRIO: Tem de ter o \Api

use App\Http\Controllers\Controller;
use App\Services\Chatbot\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request, ChatbotService $bot)
    {
        // LOG 1: Verificar se o pedido chega aqui
        Log::info('🤖 Chatbot: Pedido Recebido', [
            'ip' => $request->ip(),
            'message_length' => strlen($request->input('message', '')),
            'has_history' => $request->has('history')
        ]);

        try {
            $validated = $request->validate([
                'message' => 'required|string|max:1000',
                'history' => 'array|nullable',
            ]);

            // LOG 2: Antes de chamar o serviço (testa se o Service foi injetado)
            Log::info('🤖 Chatbot: A chamar o Serviço...');

            $response = $bot->handleMessage(
                $validated['message'],
                'pt', 
                $validated['history'] ?? []
            );

            // LOG 3: Resposta do serviço (Agora com check de áudio)
            Log::info('🤖 Chatbot: Resposta Gerada', [
                'reply_preview' => substr($response['reply'], 0, 50) . '...',
                'has_audio' => !empty($response['audio']), // Confirma se gerou voz
                'has_data' => !empty($response['data'])
            ]);

            return response()->json([
                'status' => 'success',
                'reply'  => $response['reply'],
                'audio'  => $response['audio'], // <--- VOZ ADICIONADA AQUI
                'data'   => $response['data'] 
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Erro de Validação
            Log::warning('🤖 Chatbot: Erro de Validação', $e->errors());
            return response()->json(['status' => 'error', 'message' => 'Dados inválidos.'], 422);

        } catch (\Exception $e) {
            // ERRO CRÍTICO (O tal 500)
            Log::error('🔥 Chatbot ERRO CRÍTICO: ' . $e->getMessage());
            Log::error($e->getTraceAsString()); // Guarda o rasto todo no log

            // Retorna o erro real para o navegador para tu veres no Console (só para debug)
            return response()->json([
                'status' => 'error',
                'message' => 'Erro interno: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}