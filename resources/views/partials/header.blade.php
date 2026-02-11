<header x-data="{ mobileMenuOpen: false, toolsOpen: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="{ 
            'bg-intellectus-base shadow-none py-4': mobileMenuOpen, 
            'bg-intellectus-base/95 backdrop-blur-md shadow-lg py-3': scrolled && !mobileMenuOpen, 
            'bg-transparent py-5': !scrolled && !mobileMenuOpen 
        }"
        class="fixed top-0 w-full z-50 transition-all duration-500 border-b border-white/5">
    
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between">
            
            {{-- 1. LOGO --}}
            <a href="{{ route('home') }}" class="relative z-50 group block" @click="mobileMenuOpen = false">
                <img src="{{ asset('img/Ativo_8.png') }}" 
                     alt="Intellectus | Rui Moita Private Office" 
                     class="h-8 sm:h-9 md:h-10 lg:h-12 w-auto object-contain transition-transform duration-500 group-hover:scale-105">
            </a>

            {{-- 2. DESKTOP MENU --}}
            <nav class="hidden lg:flex items-center gap-6 xl:gap-8">
                <a href="{{ route('home') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-intellectus-accent transition-colors relative group">
                    {{ __('Início') }}
                    <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-intellectus-accent group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('portfolio') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-intellectus-accent transition-colors relative group">
                    {{ __('Coleção') }}
                    <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-intellectus-accent group-hover:w-full transition-all duration-300"></span>
                </a>
                
                {{-- Dropdown Ferramentas --}}
                <div class="relative group" @mouseenter="toolsOpen = true" @mouseleave="toolsOpen = false">
                    <button class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-intellectus-accent transition-colors flex items-center gap-2 focus:outline-none py-2">
                        {{ __('Market Intelligence') }}
                        <svg class="w-3 h-3 text-intellectus-accent transition-transform duration-300" :class="{'rotate-180': toolsOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    
                    <div x-show="toolsOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute top-full left-1/2 -translate-x-1/2 pt-6 w-64">
                        
                        <div class="bg-intellectus-base border-t-2 border-intellectus-accent shadow-2xl p-0">
                            <a href="{{ route('tools.credit') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-white/5 hover:text-intellectus-accent transition-colors border-b border-white/5">
                                {{ __('Simulador Crédito') }}
                            </a>
                            <a href="{{ route('tools.imt') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-white/5 hover:text-intellectus-accent transition-colors border-b border-white/5">
                                {{ __('Simulador IMT') }}
                            </a>
                            <a href="{{ route('tools.gains') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-white/5 hover:text-intellectus-accent transition-colors">
                                {{ __('Mais-Valias (IRS)') }}
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('team') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-intellectus-accent transition-colors relative group">
                    {{ __('Equipa') }}
                    <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-intellectus-accent group-hover:w-full transition-all duration-300"></span>
                </a>

                <a href="{{ route('about') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-intellectus-accent transition-colors relative group">
                    {{ __('A Visão') }}
                    <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-intellectus-accent group-hover:w-full transition-all duration-300"></span>
                </a>

                {{-- LOGIN / DASHBOARD --}}
                @auth
                    <a href="{{ route('dashboard') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-intellectus-accent hover:text-white transition-colors relative group border border-intellectus-accent/30 px-3 py-1 rounded-sm hover:bg-intellectus-accent hover:border-transparent">
                        {{ __('Minha Conta') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/70 hover:text-white transition-colors relative group">
                        {{ __('Login') }}
                        <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-white group-hover:w-full transition-all duration-300"></span>
                    </a>
                @endauth
                
                {{-- IDIOMA DESKTOP --}}
                <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-white ml-2 border-l border-white/20 pl-4 h-6">
                    <a href="{{ route('lang.switch', 'pt') }}" class="{{ app()->getLocale() == 'pt' ? 'text-intellectus-accent cursor-default' : 'hover:text-intellectus-accent transition-colors opacity-50 hover:opacity-100' }}">PT</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-intellectus-accent cursor-default' : 'hover:text-intellectus-accent transition-colors opacity-50 hover:opacity-100' }}">EN</a>
                </div>

                <a href="{{ route('contact') }}" 
                   class="ml-2 bg-intellectus-accent text-intellectus-base px-5 py-3 uppercase text-[9px] font-bold tracking-[0.2em] border border-transparent hover:bg-white hover:text-intellectus-primary transition-all duration-500 shadow-lg">
                    {{ __('Agendar Reunião') }}
                </a>
            </nav>

            {{-- 3. MOBILE MENU BUTTON --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-intellectus-accent z-50 focus:outline-none p-2">
                <div class="w-6 flex items-center justify-center relative">
                    <span x-show="!mobileMenuOpen" class="transform transition w-full h-px bg-current absolute -translate-y-2"></span>
                    <span x-show="!mobileMenuOpen" class="transform transition w-full h-px bg-current absolute translate-y-2"></span>
                    <span x-show="!mobileMenuOpen" class="transform transition w-full h-px bg-current absolute"></span>
                    
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6 transform transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </button>
        </div>
    </div>

    {{-- 4. MOBILE MENU OVERLAY --}}
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-full"
         class="fixed inset-0 bg-intellectus-base z-40 overflow-y-auto">
        
        {{-- CONTAINER FLEXÍVEL --}}
        {{-- min-h-screen garante altura total; justify-between empurra o footer; pt-32 protege a área do logo --}}
        <div class="min-h-screen flex flex-col px-6 pt-32 pb-8">
            
            {{-- ÁREA DE NAVEGAÇÃO (Cresce para ocupar espaço) --}}
            <nav class="flex-grow flex flex-col items-center justify-center space-y-4 text-center">
                
                {{-- Links Principais (Texto ajustável: 2xl em mobile, 3xl em tablets) --}}
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="text-2xl sm:text-3xl font-serif text-white hover:text-intellectus-accent transition-colors">{{ __('Início') }}</a>
                <a href="{{ route('portfolio') }}" @click="mobileMenuOpen = false" class="text-2xl sm:text-3xl font-serif text-white hover:text-intellectus-accent transition-colors">{{ __('Coleção Privada') }}</a>
                <a href="{{ route('team') }}" @click="mobileMenuOpen = false" class="text-2xl sm:text-3xl font-serif text-white hover:text-intellectus-accent transition-colors">{{ __('Equipa') }}</a>
                <a href="{{ route('about') }}" @click="mobileMenuOpen = false" class="text-2xl sm:text-3xl font-serif text-white hover:text-intellectus-accent transition-colors">{{ __('A Visão') }}</a>
                
                @auth
                    <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="text-2xl sm:text-3xl font-serif text-intellectus-accent hover:text-white transition-colors">{{ __('Minha Conta') }}</a>
                @else
                    <a href="{{ route('login') }}" @click="mobileMenuOpen = false" class="text-2xl sm:text-3xl font-serif text-white/70 hover:text-white transition-colors">{{ __('Login') }}</a>
                @endauth

                <div class="w-10 h-[1px] bg-white/10 my-3"></div>
                
                {{-- Ferramentas --}}
                <p class="text-[9px] uppercase tracking-widest text-intellectus-accent mb-1">{{ __('Ferramentas') }}</p>
                <a href="{{ route('tools.credit') }}" @click="mobileMenuOpen = false" class="text-base font-light text-white/70 hover:text-white transition-colors">{{ __('Simulador Crédito') }}</a>
                <a href="{{ route('tools.imt') }}" @click="mobileMenuOpen = false" class="text-base font-light text-white/70 hover:text-white transition-colors">{{ __('Simulador IMT') }}</a>
                <a href="{{ route('tools.gains') }}" @click="mobileMenuOpen = false" class="text-base font-light text-white/70 hover:text-white transition-colors">{{ __('Mais-Valias (IRS)') }}</a>

                <div class="w-10 h-[1px] bg-white/10 my-3"></div>

                {{-- Idiomas --}}
                <div class="flex items-center gap-6 mb-4">
                    <a href="{{ route('lang.switch', 'pt') }}" class="text-lg font-serif {{ app()->getLocale() == 'pt' ? 'text-intellectus-accent underline decoration-1 underline-offset-4' : 'text-white/50' }}">PT</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="text-lg font-serif {{ app()->getLocale() == 'en' ? 'text-intellectus-accent underline decoration-1 underline-offset-4' : 'text-white/50' }}">EN</a>
                </div>

                <a href="{{ route('contact') }}" @click="mobileMenuOpen = false" class="px-8 py-3 bg-intellectus-accent text-intellectus-base uppercase text-[10px] font-bold tracking-widest hover:bg-white transition-colors shadow-xl">
                    {{ __('Agendar Reunião') }}
                </a>
            </nav>

            {{-- FOOTER (Agora dentro do fluxo, no fundo do contentor) --}}
            <div class="text-center mt-8 shrink-0">
                <p class="text-[9px] text-white/20 uppercase tracking-widest">Rui Moita Private Office &copy; {{ date('Y') }}</p>
            </div>
        </div>
    </div>
</header>