<header class="fixed top-6 left-0 right-0 z-50 flex justify-center px-4 pointer-events-none">
    <nav x-data="{ mobileOpen: false, toolsOpen: false }" class="pointer-events-auto bg-gray-900/90 backdrop-blur-md border border-white/10 rounded-full px-6 py-3 shadow-2xl flex items-center justify-between gap-8 transition-all duration-300 hover:bg-black w-full max-w-[1400px]">
        
        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="shrink-0 flex items-center gap-2 relative z-50">
            {{-- Garanta que a imagem existe em public/images/ --}}
            <img src="{{ asset('images/extenso.png') }}" 
                 alt="Intellectus Logo" 
                 class="h-12 w-auto object-contain">
        </a>

        {{-- MENU DESKTOP --}}
        <div class="hidden lg:flex items-center gap-6">
            <a href="{{ route('properties.index') }}" class="text-xs font-bold uppercase tracking-widest text-gray-300 hover:text-intellectus-accent transition-colors">
                {{ __('Portfólio') }}
            </a>
            <a href="{{ route('about') }}" class="text-xs font-bold uppercase tracking-widest text-gray-300 hover:text-intellectus-accent transition-colors">
                {{ __('A Marca') }}
            </a>
            <a href="{{ route('team') }}" class="text-xs font-bold uppercase tracking-widest text-gray-300 hover:text-intellectus-accent transition-colors">
                {{ __('Equipa') }}
            </a>
        </div>

        {{-- ÁREA DE LOGIN / DASHBOARD --}}
        <div class="hidden lg:flex items-center gap-4 border-l border-white/10 pl-6">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="bg-intellectus-accent text-gray-900 px-5 py-2 rounded-full text-xs font-bold uppercase tracking-widest hover:bg-white transition-colors">
                    {{ __('Dashboard') }}
                </a>
            @else
                <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-widest text-white hover:text-intellectus-accent transition-colors">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="border border-white/20 text-white px-5 py-2 rounded-full text-xs font-bold uppercase tracking-widest hover:bg-white hover:text-gray-900 transition-all">
                    {{ __('Aderir') }}
                </a>
            @endauth
        </div>

        {{-- MENU MOBILE (HAMBURGUER) --}}
        <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </nav>
</header>