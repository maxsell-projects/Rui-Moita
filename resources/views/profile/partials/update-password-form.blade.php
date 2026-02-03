<section>
    <header>
        <h2 class="text-lg font-bold text-graphite font-heading flex items-center gap-2">
            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            Segurança e Senha
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Certifique-se de que sua conta esteja usando uma senha longa e aleatória para manter a segurança.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('Senha Atual')" class="text-gray-700 font-bold" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 focus:border-accent focus:ring-accent rounded-lg" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nova Senha')" class="text-gray-700 font-bold" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full border-gray-300 focus:border-accent focus:ring-accent rounded-lg" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Nova Senha')" class="text-gray-700 font-bold" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-300 focus:border-accent focus:ring-accent rounded-lg" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-graphite hover:bg-graphite/90 border-transparent text-white shadow-md">
                {{ __('Atualizar Senha') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold flex items-center gap-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Salvo.') }}
                </p>
            @endif
        </div>
    </form>
</section>