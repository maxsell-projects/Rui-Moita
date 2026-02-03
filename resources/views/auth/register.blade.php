<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Left Side - Image -->
        <div class="hidden lg:flex lg:w-1/2 relative">
            <img
                src="{{ asset('images/hero-luxury.jpg') }}"
                alt="Luxury Portuguese Architecture"
                class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-br from-graphite/90 via-graphite/70 to-graphite/90"></div>
            
            <div class="absolute inset-0 flex flex-col justify-center px-12 text-white">
                <div class="max-w-md">
                    <h1 class="font-heading text-4xl font-bold mb-4">
                        <span class="text-white">CROW</span>
                        <span class="text-accent"> GLOBAL</span>
                    </h1>
                    <p class="text-xl mb-6">Where Vision Meets Value</p>
                    <p class="text-white/80 text-lg">
                        Premium Real Estate Investments in Portugal
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 text-center">
                    <h1 class="font-heading text-3xl font-bold">
                        <span class="text-graphite">CROW</span>
                        <span class="text-accent"> GLOBAL</span>
                    </h1>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-graphite mb-2">Solicitar Acesso</h2>
                    <p class="text-muted-foreground">Preencha os dados para criar sua conta</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Nome Completo')" class="text-graphite font-medium" />
                        <x-text-input 
                            id="name" 
                            class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-colors" 
                            type="text" 
                            name="name" 
                            :value="old('name')" 
                            required 
                            autofocus 
                            autocomplete="name"
                            placeholder="Seu nome completo"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-graphite font-medium" />
                        <x-text-input 
                            id="email" 
                            class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-colors" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autocomplete="username"
                            placeholder="seu@email.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Senha')" class="text-graphite font-medium" />
                        <x-text-input 
                            id="password" 
                            class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-colors"
                            type="password"
                            name="password"
                            required 
                            autocomplete="new-password"
                            placeholder="Mínimo 8 caracteres"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" class="text-graphite font-medium" />
                        <x-text-input 
                            id="password_confirmation" 
                            class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-colors"
                            type="password"
                            name="password_confirmation"
                            required 
                            autocomplete="new-password"
                            placeholder="Confirme sua senha"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full bg-accent hover:bg-accent/90 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 shadow-sm">
                            Criar Conta
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            Já tem uma conta?
                            <a href="{{ route('login') }}" class="text-accent hover:text-accent/80 font-medium transition-colors">
                                Fazer login
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Back to Home -->
                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-graphite transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Voltar para o site
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
