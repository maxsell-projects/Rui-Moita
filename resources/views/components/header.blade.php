<header class="fixed top-6 left-0 right-0 z-50 flex justify-center px-4 pointer-events-none">
    {{-- Ajustei o padding lateral (px-4) e o gap (lg:gap-4 xl:gap-8) para dar espaço ao logo --}}
    <nav x-data="{ mobileOpen: false, toolsOpen: false }" class="pointer-events-auto bg-gray-900/40 backdrop-blur-md border border-white/10 rounded-full px-4 lg:px-4 xl:px-6 py-3 shadow-2xl flex items-center justify-between gap-4 lg:gap-4 xl:gap-8 transition-all duration-300 hover:bg-gray-900/60 w-full max-w-[1400px]">
        
        {{-- LOGO (MANTIDO GIGANTE) --}}
        <a href="{{ route('home') }}" class="shrink-0 flex items-center gap-2 group relative z-50">
            <img src="{{ asset('images/extenso.png') }}" 
                 alt="Crow Global Logo" 
                 class="h-32 md:h-52 w-auto object-contain -my-12 md:-my-20 translate-y-1 md:translate-y-2 transition-transform duration-300 group-hover:scale-105 filter drop-shadow-2xl">
        </a>

        {{-- MENU DESKTOP --}}
       <div class="hidden lg:flex items-center gap-1 xl:gap-2 shrink-1">
            {{-- Ajustei o padding para (px-2 no LG e px-4 no XL) para evitar quebra em telas médias --}}
            <a href="{{ route('properties.index') }}" class="text-sm font-medium text-gray-200 hover:text-white hover:bg-white/10 px-2 xl:px-4 py-2 rounded-full transition-all whitespace-nowrap {{ request()->routeIs('properties.*') ? 'bg-white/10 text-white' : '' }}">
                {{ __('Explore Properties') }}
            </a>
            
            <a href="{{ route('pages.about') }}" class="text-sm font-medium text-gray-200 hover:text-white hover:bg-white/10 px-2 xl:px-4 py-2 rounded-full transition-all whitespace-nowrap {{ request()->routeIs('pages.about') ? 'bg-white/10 text-white' : '' }}">
                {{ __('About Us') }}
            </a>

            <a href="{{ route('pages.services') }}" class="text-sm font-medium text-gray-200 hover:text-white hover:bg-white/10 px-2 xl:px-4 py-2 rounded-full transition-all whitespace-nowrap {{ request()->routeIs('pages.services') ? 'bg-white/10 text-white' : '' }}">
                {{ __('Services') }}
            </a>

            {{-- DROPDOWN FERRAMENTAS --}}
            <div class="relative" @click.away="toolsOpen = false">
                <button @click="toolsOpen = !toolsOpen" class="flex items-center gap-1 text-sm font-medium text-gray-200 hover:text-white hover:bg-white/10 px-2 xl:px-4 py-2 rounded-full transition-all whitespace-nowrap {{ request()->routeIs('tools.*') ? 'bg-white/10 text-white' : '' }}">
                    <span>{{ __('Simulators') }}</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="toolsOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="toolsOpen" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute top-full left-0 mt-2 w-56 bg-gray-900 border border-white/10 rounded-xl shadow-xl overflow-hidden py-1 z-50"
                     style="display: none;">
                    
                    <a href="{{ route('tools.gains') }}" class="block px-4 py-3 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-colors">
                        {{ __('Capital Gains') }}
                    </a>
                    <a href="{{ route('tools.imt') }}" class="block px-4 py-3 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-colors">
                        {{ __('IMT & Stamp Duty') }}
                    </a>
                    <a href="{{ route('tools.credit') }}" class="block px-4 py-3 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-colors">
                        {{ __('Mortgage') }}
                    </a>
                </div>
            </div>

            <a href="{{ route('pages.sell') }}" class="text-sm font-medium text-gray-200 hover:text-white hover:bg-white/10 px-2 xl:px-4 py-2 rounded-full transition-all whitespace-nowrap {{ request()->routeIs('pages.sell') ? 'bg-white/10 text-white' : '' }}">
                {{ __('Sell with us') }}
            </a>
        </div>

        {{-- ACTIONS (Adicionei 'shrink-0' aqui para impedir que os botões encolham) --}}
        <div class="hidden lg:flex items-center gap-2 xl:gap-4 shrink-0">
            
            {{-- LANGUAGE SWITCHER --}}
            <div class="flex items-center bg-black/20 rounded-full px-1 py-1 border border-white/5 shrink-0">
                <a href="{{ route('language.switch', 'pt') }}" class="px-2 xl:px-3 py-1 rounded-full text-xs font-bold transition-all {{ app()->getLocale() == 'pt' ? 'bg-accent text-white shadow-sm' : 'text-gray-400 hover:text-white' }}">PT</a>
                <a href="{{ route('language.switch', 'en') }}" class="px-2 xl:px-3 py-1 rounded-full text-xs font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-accent text-white shadow-sm' : 'text-gray-400 hover:text-white' }}">EN</a>
                <a href="{{ route('language.switch', 'fr') }}" class="px-2 xl:px-3 py-1 rounded-full text-xs font-bold transition-all {{ app()->getLocale() == 'fr' ? 'bg-accent text-white shadow-sm' : 'text-gray-400 hover:text-white' }}">FR</a>
            </div>

            <div class="w-px h-6 bg-white/20 mx-1"></div>

            @if (Route::has('login'))
                @auth
                    {{-- Botão Dashboard --}}
                    <a href="{{ url('/dashboard') }}" class="shrink-0 text-sm font-bold text-white bg-white/10 hover:bg-white/20 border border-white/10 px-4 xl:px-5 py-2 rounded-full transition-all whitespace-nowrap">
                        {{ __('Dashboard') }}
                    </a>
                @else
                    {{-- Botão Login --}}
                    <a href="{{ route('login') }}" class="shrink-0 text-sm font-medium text-gray-200 hover:text-white px-2 transition-colors whitespace-nowrap">
                        {{ __('Log in') }}
                    </a>
                    {{-- Botão Request Access --}}
                    <a href="{{ route('pages.contact') }}" class="shrink-0 text-sm font-bold text-graphite bg-accent hover:bg-white hover:text-accent px-4 xl:px-5 py-2 rounded-full transition-all shadow-lg shadow-accent/20 whitespace-nowrap">
                        {{ __('Request Access') }}
                    </a>
                @endauth
            @endif
        </div>

        {{-- MOBILE TOGGLE --}}
        <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-gray-200 hover:text-white focus:outline-none shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>

        {{-- MOBILE MENU (Sem alterações de lógica) --}}
        <div x-show="mobileOpen" 
             @click.away="mobileOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
             class="absolute top-full left-0 right-0 mt-4 bg-gray-900/95 backdrop-blur-xl border border-white/10 rounded-2xl p-4 shadow-xl lg:hidden flex flex-col gap-2 max-h-[80vh] overflow-y-auto" 
             style="display: none;">
            
            <a href="{{ route('properties.index') }}" class="block text-gray-300 hover:text-white hover:bg-white/5 px-4 py-3 rounded-xl transition-colors">
                {{ __('Explore Properties') }}
            </a>
            <a href="{{ route('pages.about') }}" class="block text-gray-300 hover:text-white hover:bg-white/5 px-4 py-3 rounded-xl transition-colors">
                {{ __('About Us') }}
            </a>
            <a href="{{ route('pages.services') }}" class="block text-gray-300 hover:text-white hover:bg-white/5 px-4 py-3 rounded-xl transition-colors">
                {{ __('Services') }}
            </a>
            
            {{-- Ferramentas Mobile --}}
            <div x-data="{ toolsMobileOpen: false }">
                <button @click="toolsMobileOpen = !toolsMobileOpen" class="w-full flex justify-between items-center text-gray-300 hover:text-white hover:bg-white/5 px-4 py-3 rounded-xl transition-colors">
                    <span>{{ __('Simulators') }}</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="toolsMobileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="toolsMobileOpen" class="pl-4 border-l border-white/10 ml-4 mt-1 space-y-1">
                    <a href="{{ route('tools.gains') }}" class="block text-gray-400 hover:text-white px-4 py-2 rounded-lg text-sm">{{ __('Capital Gains') }}</a>
                    <a href="{{ route('tools.imt') }}" class="block text-gray-400 hover:text-white px-4 py-2 rounded-lg text-sm">{{ __('IMT & Stamp Duty') }}</a>
                    <a href="{{ route('tools.credit') }}" class="block text-gray-400 hover:text-white px-4 py-2 rounded-lg text-sm">{{ __('Mortgage') }}</a>
                </div>
            </div>

            <a href="{{ route('pages.sell') }}" class="block text-gray-300 hover:text-white hover:bg-white/5 px-4 py-3 rounded-xl transition-colors">
                {{ __('Sell with us') }}
            </a>

            <div class="flex justify-center gap-4 py-3 border-y border-white/10 my-1">
                <a href="{{ route('language.switch', 'pt') }}" class="text-sm font-bold {{ app()->getLocale() == 'pt' ? 'text-accent' : 'text-gray-400' }}">PT</a>
                <span class="text-gray-600">|</span>
                <a href="{{ route('language.switch', 'en') }}" class="text-sm font-bold {{ app()->getLocale() == 'en' ? 'text-accent' : 'text-gray-400' }}">EN</a>
                <span class="text-gray-600">|</span>
                <a href="{{ route('language.switch', 'fr') }}" class="text-sm font-bold {{ app()->getLocale() == 'fr' ? 'text-accent' : 'text-gray-400' }}">FR</a>
            </div>
            
            @auth
                <a href="{{ url('/dashboard') }}" class="block text-accent font-bold px-4 py-3 rounded-xl bg-white/5 text-center">
                    {{ __('Dashboard') }}
                </a>
            @else
                <div class="grid grid-cols-2 gap-3 mt-2 pt-2">
                    <a href="{{ route('login') }}" class="text-center text-gray-300 py-3 rounded-xl hover:bg-white/5 border border-white/10">
                        {{ __('Log in') }}
                    </a>
                    <a href="{{ route('pages.contact') }}" class="text-center bg-accent text-white font-bold py-3 rounded-xl shadow-lg">
                        {{ __('Request Access') }}
                    </a>
                </div>
            @endauth
        </div>
    </nav>
</header>