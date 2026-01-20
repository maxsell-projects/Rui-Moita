<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Marco Moura | Private Office</title>
    
    {{-- FAVICON --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- ASSETS (Vite + Tailwind v4) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- FONTES --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Manrope:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    {{-- LIB DE ANIMAÇÃO --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- ALPINE.JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Manrope', sans-serif; }
        
        /* Ajustes de scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #FDFBF7; }
        ::-webkit-scrollbar-thumb { background: #8D182B; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #1D4C42; }

        html, body {
            max-width: 100%;
            overflow-x: hidden !important;
            position: relative;
        }
    </style>
</head>
<body class="font-sans antialiased text-brand-text bg-brand-background selection:bg-brand-primary selection:text-white"
      x-data="{ 
          showConsent: false,
          showPrivacyModal: false,
          showExitPopup: false,
          init() {
              if (!localStorage.getItem('cookie_consent')) {
                  setTimeout(() => this.showConsent = true, 2000);
              }
          },
          acceptCookies() {
              localStorage.setItem('cookie_consent', 'true');
              this.showConsent = false;
          },
          handleExitIntent(e) {
              if (e.clientY <= 0 && !sessionStorage.getItem('exit_popup_shown')) {
                  this.showExitPopup = true;
                  sessionStorage.setItem('exit_popup_shown', 'true');
              }
          }
      }"
      @mouseleave.document="handleExitIntent($event)">

    {{-- WRAPPER --}}
    <div class="w-full overflow-x-hidden relative flex flex-col min-h-screen">
        @include('partials.header')

        <main class="flex-grow">
            @yield('content')
        </main>

        {{-- FOOTER MODULAR --}}
        @include('partials.footer')
    </div>

    {{-- BOTÃO WHATSAPP (Fixo) --}}
    <div class="fixed bottom-24 md:bottom-6 left-6 z-40 print:hidden group">
        <a href="https://wa.me/351910000000" target="_blank"
           class="w-14 h-14 bg-[#25D366] text-white shadow-2xl rounded-full flex items-center justify-center hover:bg-[#128C7E] transition-all duration-300 hover:scale-110 border-2 border-white relative overflow-hidden"
           title="WhatsApp Direto">
            <svg class="w-7 h-7 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
        </a>
    </div>

    {{-- NAVEGAÇÃO FLUTUANTE (Voltar + Topo) --}}
    <div class="fixed bottom-28 right-6 z-40 flex flex-col gap-4 print:hidden" 
         x-data="{ showTop: false }" 
         @scroll.window="showTop = (window.pageYOffset > 300)">
        
        {{-- Botão Voltar (SVG corrigido) --}}
        <button @click="window.history.back()" 
                class="w-12 h-12 bg-white text-brand-secondary shadow-lg rounded-full flex items-center justify-center hover:bg-brand-secondary hover:text-white transition-all duration-300 border border-brand-secondary/10 group transform hover:-translate-x-1"
                title="Voltar">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </button>

        {{-- Botão Topo --}}
        <button @click="window.scrollTo({top: 0, behavior: 'smooth'})" 
                x-show="showTop" 
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="w-12 h-12 bg-brand-primary text-white shadow-lg rounded-full flex items-center justify-center hover:bg-brand-secondary transition-all duration-300 transform hover:-translate-y-1 border border-brand-sand/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>
    </div>

    {{-- EXIT POPUP (Capture Lead) --}}
    <div x-show="showExitPopup" 
         x-cloak
         style="display: none;"
         x-transition.opacity.duration.300ms
         class="fixed inset-0 z-[80] flex items-center justify-center p-4 bg-brand-secondary/95 backdrop-blur-sm">
        
        <div @click.outside="showExitPopup = false" 
             class="bg-white w-full max-w-md rounded-sm shadow-2xl relative overflow-hidden text-center p-10 border-t-8 border-brand-primary">
            
            <button @click="showExitPopup = false" class="absolute top-4 right-4 text-gray-300 hover:text-brand-primary transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            
            <div class="mb-8">
                <div class="w-16 h-16 bg-brand-secondary rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg border-2 border-brand-sand">
                    <svg class="w-8 h-8 text-brand-sand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-serif text-brand-secondary mb-3">Não vá com dúvidas.</h3>
                <p class="text-sm text-gray-500 leading-relaxed font-light">
                    O mercado imobiliário muda rapidamente. <br>Se procura um conselho estratégico, estou disponível agora no WhatsApp.
                </p>
            </div>
            
            <a href="https://wa.me/351910000000" target="_blank" @click="showExitPopup = false"
               class="flex items-center justify-center gap-3 w-full bg-brand-primary hover:bg-brand-secondary text-white font-bold uppercase tracking-widest py-4 rounded-sm transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-xs">
                Falar no WhatsApp
            </a>
            
            <button @click="showExitPopup = false" class="mt-4 text-xs text-gray-400 hover:text-brand-primary border-b border-transparent hover:border-brand-primary transition-all pb-0.5">
                Não, obrigado. Continuar a navegar.
            </button>
        </div>
    </div>

    {{-- Parciais --}}
    {{-- O Modal de Privacidade está gerido dentro do partials/footer por questões de z-index, mas o consentimento visual está aqui --}}
    @include('partials.privacy-consent')
    
    @include('components.chatbot')

    {{-- SCRIPTS (AOS) --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ 
            duration: 1000, 
            once: true, 
            offset: 50,
            easing: 'ease-out-cubic'
        });
    </script>
</body>
</html>