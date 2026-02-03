<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-10">
        <h2 class="font-serif text-3xl text-intellectus-primary mb-2">{{ __('Private Office') }}</h2>
        <p class="text-xs font-bold uppercase tracking-widest text-intellectus-muted">{{ __('Acesso Reservado') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block font-sans text-xs font-bold uppercase tracking-widest text-intellectus-primary mb-2">
                {{ __('Email') }}
            </label>
            <input id="email" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-intellectus-primary/20 focus:border-intellectus-accent focus:ring-0 px-0 py-3 text-intellectus-text placeholder-gray-400 transition-colors" 
                   type="email" 
                   name="email" 
                   :value="old('email')" 
                   required autofocus autocomplete="username"
                   placeholder="seu.email@intellectus.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <label for="password" class="block font-sans text-xs font-bold uppercase tracking-widest text-intellectus-primary mb-2">
                {{ __('Password') }}
            </label>
            <input id="password" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-intellectus-primary/20 focus:border-intellectus-accent focus:ring-0 px-0 py-3 text-intellectus-text placeholder-gray-400 transition-colors" 
                   type="password" 
                   name="password" 
                   required autocomplete="current-password"
                   placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-intellectus-primary shadow-sm focus:ring-intellectus-accent transition-colors" name="remember">
                <span class="ms-2 text-xs text-gray-500 group-hover:text-intellectus-primary transition-colors">{{ __('Lembrar-me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-gray-400 hover:text-intellectus-accent transition-colors underline decoration-1 underline-offset-4" href="{{ route('password.request') }}">
                    {{ __('Esqueceu a senha?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center items-center px-4 py-4 bg-intellectus-primary border border-transparent rounded-sm font-bold text-xs text-white uppercase tracking-[0.2em] hover:bg-intellectus-accent hover:text-intellectus-primary active:bg-intellectus-base focus:outline-none transition ease-in-out duration-300 shadow-lg">
                {{ __('Entrar') }}
            </button>
        </div>
    </form>
    
    <div class="mt-8 text-center border-t border-gray-100 pt-6">
        <p class="text-xs text-gray-400">
            {{ __('Ainda não tem acesso?') }}
            <a href="{{ route('contact') }}" class="text-intellectus-primary font-bold hover:text-intellectus-accent transition-colors ml-1">
                {{ __('Solicitar Adesão') }}
            </a>
        </p>
    </div>
</x-guest-layout>