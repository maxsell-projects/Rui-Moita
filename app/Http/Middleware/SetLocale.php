<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se a sessão tiver 'locale', define a app para esse idioma
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}