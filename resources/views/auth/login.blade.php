<x-guest-layout>
    <div class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 relative">
            <img src="{{ asset('images/hero-luxury.jpg') }}" alt="Luxury" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-br from-graphite/90 via-graphite/70 to-graphite/90"></div>
            
            <div class="absolute inset-0 flex flex-col justify-center px-12 text-white">
                <div class="max-w-md">
                    <h1 class="font-heading text-4xl font-bold mb-4">
                        <span class="text-white">{{ __('messages.hero_title_1') }}</span>
                        <span class="text-accent"> {{ __('messages.hero_title_2') }}</span>
                    </h1>
                    <p class="text-xl mb-6">{{ __('messages.hero_subtitle') }}</p>
                    <p class="text-white/80 text-lg">{{ __('messages.hero_desc') }}</p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white">
            <div class="w-full max-w-md">
                <div class="lg:hidden mb-8 text-center">
                    <h1 class="font-heading text-3xl font-bold">
                        <span class="text-graphite">CROW</span><span class="text-accent"> GLOBAL</span>
                    </h1>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-graphite mb-2">{{ __('messages.login_title') }}</h2>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="email" :value="__('messages.email')" class="text-graphite font-medium" />
                        <x-text-input id="email" class="block mt-2 w-full px-4 py-3 rounded-lg" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-input-label for="password" :value="__('messages.password')" class="text-graphite font-medium" />
                        <x-text-input id="password" class="block mt-2 w-full px-4 py-3 rounded-lg pr-10" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-accent focus:ring-accent" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('messages.remember_me') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-accent hover:underline" href="{{ route('password.request') }}">{{ __('messages.forgot_password') }}</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-accent hover:bg-accent/90 text-white font-bold py-3 px-4 rounded-lg shadow-sm transition-colors">
                        {{ __('messages.login_button') }}
                    </button>

                    @if (Route::has('register'))
                        <div class="text-center pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                {{ __('messages.no_account') }}
                                <a href="{{ route('register') }}" class="text-accent hover:underline font-bold">{{ __('messages.request_access') }}</a>
                            </p>
                        </div>
                    @endif
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-graphite flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        {{ __('messages.back_home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>