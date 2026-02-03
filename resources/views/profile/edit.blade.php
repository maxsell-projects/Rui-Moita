<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-graphite leading-tight font-heading">
            Configurações da Conta
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 text-center p-8 sticky top-24">
                        <div class="relative w-24 h-24 mx-auto mb-4">
                            <div class="w-full h-full bg-graphite rounded-full flex items-center justify-center text-white text-3xl font-bold border-4 border-accent shadow-lg">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        
                        <h3 class="text-xl font-bold text-graphite font-heading">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>
                        
                        <div class="border-t border-gray-100 pt-4 mt-4">
                            <div class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-2">Tipo de Conta</div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                  ($user->role === 'developer' ? 'bg-blue-100 text-blue-800' : 'bg-accent/10 text-accent') }}">
                                {{ $user->role === 'admin' ? 'Administrador' : 
                                  ($user->role === 'developer' ? 'Parceiro Developer' : 'Investidor Premium') }}
                            </span>
                        </div>

                        <div class="mt-6 text-left">
                            <p class="text-xs text-gray-400 mb-2">Segurança da Conta</p>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                <div class="bg-green-500 h-1.5 rounded-full" style="width: 85%"></div>
                            </div>
                            <p class="text-right text-xs text-green-600 mt-1 font-bold">Alta</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="p-4 sm:p-8 bg-white shadow-lg rounded-2xl border border-gray-100">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow-lg rounded-2xl border border-gray-100">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow-lg rounded-2xl border border-red-100">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>