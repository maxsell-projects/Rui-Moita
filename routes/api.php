<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// CORREÇÃO: O nome deve ser 'chatbot.send' para bater com o {{ route('chatbot.send') }} do blade
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])
    ->name('chatbot.send');

// Rota de usuário (opcional, mantive seu exemplo)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});