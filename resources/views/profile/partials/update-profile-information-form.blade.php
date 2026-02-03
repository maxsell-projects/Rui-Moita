<section>
    <header>
        <h2 class="text-lg font-bold text-graphite font-heading flex items-center gap-2">
            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Informações Pessoais
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Atualize as informações do seu perfil e endereço de email para contato.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nome Completo')" class="text-gray-700 font-bold" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-accent focus:ring-accent rounded-lg" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Endereço de Email')" class="text-gray-700 font-bold" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 focus:border-accent focus:ring-accent rounded-lg" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <p class="text-sm text-yellow-800">
                        {{ __('Seu endereço de email não foi verificado.') }}

                        <button form="send-verification" class="underline text-sm text-yellow-900 hover:text-yellow-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                            {{ __('Clique aqui para reenviar o email de verificação.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Um novo link de verificação foi enviado para seu email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-graphite hover:bg-graphite/90 border-transparent text-white shadow-md">
                {{ __('Salvar Alterações') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold flex items-center gap-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Salvo com sucesso.') }}
                </p>
            @endif
        </div>
    </form>
</section>