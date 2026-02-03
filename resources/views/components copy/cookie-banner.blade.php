<div x-data="{ show: !localStorage.getItem('cookie_consent') }" 
     x-show="show" 
     x-transition.opacity.duration.500ms
     class="fixed bottom-0 left-0 w-full bg-gray-900 text-white p-4 z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] border-t border-gray-700">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-300">
            <p>
                {{ __('Este website utiliza cookies para melhorar a sua experiência. Ao continuar a navegar, concorda com a nossa') }}
                <a href="{{ route('legal.cookies') }}" class="underline text-crow-accent hover:text-white transition-colors">{{ __('Política de Cookies') }}</a>.
            </p>
        </div>
        <div class="flex gap-3">
            <button @click="show = false; localStorage.setItem('cookie_consent', 'accepted')" 
                    class="bg-crow-accent hover:bg-yellow-600 text-white px-6 py-2 rounded-md text-sm font-semibold transition-colors">
                {{ __('Aceitar Todos') }}
            </button>
        </div>
    </div>
</div>