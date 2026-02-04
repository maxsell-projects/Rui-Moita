<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Intellectus') }}</title>

        {{-- FONTS (Inter + Playfair Display) --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            
            /* Scrollbar Personalizada Intellectus */
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: #F5F5F2; }
            ::-webkit-scrollbar-thumb { background: #1B2A41; border-radius: 4px; border: 2px solid #F5F5F2; }
            ::-webkit-scrollbar-thumb:hover { background: #C5A059; }
        </style>
    </head>
    <body class="font-sans text-intellectus-text antialiased bg-intellectus-surface selection:bg-intellectus-primary selection:text-white relative">
        
        {{-- WRAPPER PRINCIPAL (Alterado para suportar Footer) --}}
        <div class="min-h-screen flex flex-col justify-between">
            
            {{-- CONTEÚDO CENTRALIZADO (Login/Register) --}}
            <main class="flex-grow flex flex-col justify-center items-center pt-6 sm:pt-0">
                {{-- Logo Link acima do form --}}
                <div class="mb-6">
                    <a href="/">
                        <img src="{{ asset('images/hero.png') }}" class="w-20 h-20 fill-current text-intellectus-primary" alt="Intellectus Logo" />
                    </a>
                </div>

                {{-- Container do Formulário --}}
                <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-2xl overflow-hidden sm:rounded-lg border-t-4 border-intellectus-accent">
                    {{ $slot }}
                </div>
            </main>

            {{-- FOOTER INCLUÍDO AQUI --}}
            @include('partials.footer')

        </div>

        {{-- Floating Action Buttons --}}
        <div class="fixed bottom-6 right-6 flex flex-col gap-4 z-40" x-data="{ showTop: false }" @scroll.window="showTop = (window.pageYOffset > 300)">
            
            {{-- Back Button --}}
            <button onclick="window.history.back()" 
                    class="w-12 h-12 bg-white text-intellectus-primary rounded-full shadow-lg flex items-center justify-center hover:bg-intellectus-surface hover:scale-110 transition-all duration-300 border border-gray-200"
                    title="{{ __('Go Back') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </button>

            {{-- WhatsApp Button --}}
            <a href="https://wa.me/351918765491" target="_blank" 
               class="w-12 h-12 bg-[#25D366] text-white rounded-full shadow-lg flex items-center justify-center hover:bg-[#20bd5a] hover:scale-110 transition-all duration-300 border-2 border-white"
               title="WhatsApp">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-8.68-2.031-9.67-.272-.161-.47-.149-.734-.15-1.29 0-2.135.25-3.235.619-3.243 2.65 3.465 5.06 6.139 5.792.835 1.127 1.34 3.09 1.63 3.662.3.57.546.619.895.669.347.05 1.05.744 1.218.868.167.124.275.248.125.496-.149.248-.87 1.29-.982 1.488-.112.198-.415.223-.694.099-.272-.124-1.397-.619-2.327-1.439-1.258-1.114-2.108-2.478-2.355-2.923-.05-.248.026-.446.336-.757l.556-.706c.075-.124.037-.248-.025-.372-.062-.124-.62-1.242-1.02-1.615-.402-.375-.623-.332-.821-.332-.198 0-.463.028-.705.028-.248 0-.645.099-.97.471-.325.372-1.264 1.254-1.264 3.064 0 1.81 1.313 3.56 1.488 3.808.174.248 2.508 3.045 6.077 4.545 2.193.921 3.148.98 4.316.719 1.278-.285 2.45-1.503 2.548-2.208.099-.705.472-1.575.124-2.208z"/>
                </svg>
            </a>

            {{-- Scroll to Top Button --}}
            <button x-show="showTop" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-4"
                    @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="w-12 h-12 bg-intellectus-primary text-intellectus-accent border border-intellectus-accent rounded-full shadow-lg flex items-center justify-center hover:bg-intellectus-accent hover:text-intellectus-primary hover:scale-110 transition-all duration-300"
                    title="{{ __('Back to Top') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                </svg>
            </button>
        </div>

        {{-- Cookie Banner Component --}}
        <x-cookie-banner />
    </body>
</html>