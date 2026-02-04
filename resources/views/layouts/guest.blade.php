<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Intellectus') }}</title>

        {{-- FONTS --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: #F5F5F2; }
            ::-webkit-scrollbar-thumb { background: #1B2A41; border-radius: 4px; border: 2px solid #F5F5F2; }
            ::-webkit-scrollbar-thumb:hover { background: #C5A059; }
        </style>
    </head>
    <body class="font-sans antialiased text-intellectus-text selection:bg-intellectus-primary selection:text-white">
        
        {{-- WRAPPER COM BACKGROUND DA HOME --}}
        <div class="min-h-screen flex flex-col relative overflow-hidden bg-intellectus-base">
            
            {{-- IMAGEM DE FUNDO (Igual à Home) --}}
            <div class="absolute inset-0 z-0">
                 <img src="{{ asset('img/porto_dark.jpeg') }}" alt="Background" class="w-full h-full object-cover opacity-40">
                 <div class="absolute inset-0 bg-gradient-to-b from-intellectus-base/60 via-intellectus-base/80 to-intellectus-base"></div>
            </div>

            {{-- CONTEÚDO CENTRAL --}}
            <main class="flex-grow flex flex-col justify-center items-center py-20 px-6 sm:px-0 relative z-10">
                {{-- Container do Formulário (Logo Removida) --}}
                <div class="w-full sm:max-w-md px-8 py-12 bg-white/95 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-sm border-t-4 border-intellectus-accent">
                    {{ $slot }}
                </div>
            </main>

            {{-- FOOTER --}}
            <div class="relative z-10">
                @include('partials.footer')
            </div>
        </div>

        {{-- Floating Buttons --}}
        <div class="fixed bottom-6 left-6 flex flex-col gap-4 z-40" x-data="{ showTop: false }" @scroll.window="showTop = (window.pageYOffset > 300)">
            <button onclick="window.history.back()" class="w-12 h-12 bg-white text-intellectus-primary rounded-full shadow-lg flex items-center justify-center hover:scale-110 transition-all border border-gray-200" title="{{ __('Go Back') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </button>
        </div>

        <x-cookie-banner />
    </body>
</html>