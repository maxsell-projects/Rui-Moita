<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. AQUI: Registra os "Apelidos" para usar nas Rotas
        // Sem isso, o Laravel não sabe o que é 'active_access' ou 'admin'
        $middleware->alias([
            'active_access' => \App\Http\Middleware\EnsureUserHasActiveAccess::class,
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);

        // 2. Registra o middleware de idioma no grupo 'web' (Mantive o seu código)
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();