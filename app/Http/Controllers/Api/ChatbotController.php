<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Chatbot\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Endpoint principal que processa a mensagem e retorna Texto + Áudio.
     */
    public function sendMessage(Request $request, ChatbotService $bot)
    {
        // 1. Validação simples e robusta
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'array|nullable', // Histórico da conversa para contexto
            'history.*.role' => 'in:user,assistant,system,tool',
            'history.*.content' => 'nullable|string',
        ]);

        try {
            // 2. Detectar o idioma (Prioridade: Sessão > Cookie > Config > Default)
            $locale = session('locale', $request->cookie('crow_locale', config('app.locale')));

            // 3. Montar histórico sanitizado
            $history = $validated['history'] ?? [];

            // 4. Delegar para o Service (O Cérebro)
            $response = $bot->handleMessage(
                $validated['message'],
                $locale,
                $history
            );

            // 5. Retornar JSON estruturado
            return response()->json([
                'status' => 'success',
                'reply'  => $response['reply'], // Texto
                'audio'  => $response['audio'], // Base64 MP3
                'data'   => $response['data']   // Imóveis ou cards
            ]);

        } catch (\Exception $e) {
            // Logar o erro real para nós (devs)
            Log::error('Chatbot Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            // Retornar erro genérico amigável para o usuário
            return response()->json([
                'status' => 'error',
                'message' => 'Desculpe, estou processando muita informação agora. Tente novamente em instantes.'
            ], 500);
        }
    }
}