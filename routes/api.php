<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;

Route::prefix('v1/chatbot')->group(function () {
    // Rota principal do chat (Remova o 'chatbot' do nome da rota pois já está no prefixo)
    Route::post('/message', [ChatbotController::class, 'sendMessage']);

    // Listagem de imóveis
    Route::get('/properties', [ChatbotController::class, 'properties']);
    
    // Rotas que precisam de proteção (Middleware)
    Route::middleware(['chatbot.auth'])->group(function () {
        Route::post('/check-status', [ChatbotController::class, 'checkStatus']);
        Route::post('/lead', [ChatbotController::class, 'storeLead']);
    });
});