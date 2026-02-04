<x-app-layout>
    {{-- Header Personalizado --}}
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-serif font-bold text-intellectus-primary">
                        {{ __('messages.my_properties') }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 font-light">{{ __('Manage your portfolio and client access.') }}</p>
                </div>
                <a href="{{ route('properties.create') }}" class="inline-flex items-center px-6 py-3 bg-intellectus-accent text-intellectus-base rounded-sm shadow-lg text-xs font-bold uppercase tracking-widest hover:bg-white hover:text-intellectus-accent transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('messages.add_property') }}
                </a>
            </div>
        </div>
    </div>

    <div class="py-12 bg-intellectus-surface" x-data="accessManager()">
        <div class="max-w-7xl mx-auto px-6">
            
            {{-- Mensagens de Sucesso --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                     class="mb-8 bg-green-50 border-l-4 border-green-500 p-4 shadow-sm flex items-center justify-between"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-800">&times;</button>
                </div>
            @endif

            @if($properties->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($properties as $property)
                        <div class="bg-white rounded-sm shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group flex flex-col h-full">
                            {{-- Imagem e Badges --}}
                            <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                                @if($property->cover_image)
                                    <img src="{{ Storage::url($property->cover_image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-[10px] uppercase tracking-widest">{{ __('messages.no_image') }}</span>
                                    </div>
                                @endif
                                
                                <div class="absolute top-4 left-4 flex flex-col gap-2">
                                    @if($property->status === 'active')
                                        <span class="bg-green-600/90 backdrop-blur-sm text-white px-3 py-1 rounded-sm text-[10px] font-bold uppercase tracking-widest shadow-sm">{{ __('messages.active') }}</span>
                                    @elseif($property->status === 'negotiating')
                                        <span class="bg-yellow-500/90 backdrop-blur-sm text-white px-3 py-1 rounded-sm text-[10px] font-bold uppercase tracking-widest shadow-sm">{{ __('messages.negotiating') }}</span>
                                    @elseif($property->status === 'draft')
                                        <span class="bg-gray-500/90 backdrop-blur-sm text-white px-3 py-1 rounded-sm text-[10px] font-bold uppercase tracking-widest shadow-sm">{{ __('messages.draft') }}</span>
                                    @endif

                                    @if($property->is_exclusive)
                                        <span class="bg-intellectus-accent/90 backdrop-blur-sm text-intellectus-base px-3 py-1 rounded-sm text-[10px] font-bold uppercase tracking-widest shadow-sm border border-white/20">{{ __('messages.off_market') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Conteúdo do Card --}}
                            <div class="p-6 flex-grow">
                                <h3 class="text-lg font-serif font-bold text-intellectus-primary mb-1 truncate leading-tight group-hover:text-intellectus-accent transition-colors">{{ $property->title }}</h3>
                                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-4">{{ $property->city }}</p>
                                
                                <div class="grid grid-cols-2 gap-4 text-xs text-gray-500 border-t border-gray-100 pt-4 mt-auto">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-intellectus-primary">{{ $property->formatted_price }}</span>
                                    </div>
                                    <div class="text-right uppercase tracking-wider text-[10px]">
                                        {{ $property->type }}
                                    </div>
                                </div>
                            </div>

                            {{-- Botões de Ação --}}
                            <div class="bg-gray-50 p-4 border-t border-gray-100 flex flex-col gap-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('properties.edit', $property) }}" class="flex-1 bg-white border border-gray-200 hover:border-intellectus-accent hover:text-intellectus-accent text-gray-600 font-bold py-2 rounded-sm text-[10px] uppercase tracking-widest text-center transition-all shadow-sm">
                                        {{ __('messages.edit') }}
                                    </a>
                                    
                                    <button @click="openModal({{ $property->id }}, '{{ $property->title }}')" class="flex-1 bg-intellectus-primary hover:bg-intellectus-primary/90 text-white font-bold py-2 rounded-sm text-[10px] uppercase tracking-widest transition-all shadow-sm">
                                        {{ __('messages.manage_access') }}
                                    </button>
                                </div>
                                
                                <div class="flex justify-between items-center px-1">
                                    <a href="{{ route('properties.show', $property) }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-intellectus-accent transition-colors flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        {{ __('messages.view_as_client') }}
                                    </a>
                                    <button onclick="confirmDelete({{ $property->id }})" class="text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-600 transition-colors flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        {{ __('messages.delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $properties->links() }}
                </div>
            @else
                <div class="bg-white rounded-sm shadow-sm p-16 text-center border border-gray-100">
                    <div class="w-20 h-20 bg-intellectus-surface rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-intellectus-primary mb-2">{{ __('messages.no_properties') }}</h3>
                    <p class="text-gray-500 text-sm mb-8 font-light max-w-md mx-auto">{{ __('Start building your exclusive portfolio today by adding your first luxury property.') }}</p>
                    <a href="{{ route('properties.create') }}" class="inline-block bg-intellectus-accent hover:bg-intellectus-primary text-white font-bold py-3 px-8 rounded-sm shadow-lg transition-colors text-xs uppercase tracking-widest">
                        {{ __('messages.add_first_property') }}
                    </a>
                </div>
            @endif
        </div>

        {{-- Modal de Gestão de Acesso --}}
        <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
            <div class="fixed inset-0 bg-intellectus-primary/80 backdrop-blur-sm transition-opacity" 
                 x-show="isOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeModal()"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-sm bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border-t-4 border-intellectus-accent"
                     x-show="isOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="bg-white px-6 py-6">
                        <h3 class="text-xl font-serif font-bold text-intellectus-primary mb-2">{{ __('messages.access_title') }}</h3>
                        <p class="text-sm font-bold text-intellectus-accent mb-1" x-text="currentPropertyTitle"></p>
                        <p class="text-xs text-gray-400 mb-6 uppercase tracking-widest">{{ __('messages.select_investors') }}</p>
                        
                        <div class="max-h-60 overflow-y-auto border border-gray-100 rounded-sm divide-y divide-gray-100 bg-gray-50/50" x-show="!loading">
                            <template x-for="client in clients" :key="client.id">
                                <div class="flex items-center justify-between p-3 hover:bg-white transition-colors group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-intellectus-surface text-intellectus-primary border border-gray-200 flex items-center justify-center font-serif font-bold text-xs" x-text="client.name.substring(0,1)"></div>
                                        <div>
                                            <p class="text-sm font-bold text-intellectus-primary group-hover:text-intellectus-accent transition-colors" x-text="client.name"></p>
                                            <p class="text-[10px] uppercase tracking-wider text-gray-400" x-text="client.email"></p>
                                        </div>
                                    </div>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" 
                                               :checked="allowedIds.includes(client.id)" 
                                               @change="toggleAccess(client.id, $event.target.checked)">
                                        <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-intellectus-accent"></div>
                                    </label>
                                </div>
                            </template>
                            <div x-show="clients.length === 0" class="text-center py-6">
                                <p class="text-gray-400 text-xs mb-2">{{ __('messages.no_clients') }}</p>
                                <a href="{{ route('developer.clients') }}" class="text-intellectus-accent text-xs font-bold uppercase tracking-widest hover:underline">{{ __('messages.add_clients_link') }}</a>
                            </div>
                        </div>
                        <div x-show="loading" class="py-8 text-center text-gray-400 text-xs uppercase tracking-widest animate-pulse">{{ __('messages.loading_list') }}</div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="closeModal()" class="w-full inline-flex justify-center rounded-sm bg-white px-4 py-2 text-xs font-bold uppercase tracking-widest text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">{{ __('messages.close') }}</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de Confirmação de Exclusão --}}
        <div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="fixed inset-0 bg-intellectus-primary/90 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-sm bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-md p-6">
                    <div class="text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 mb-4">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                        </div>
                        <h3 class="text-lg font-serif font-bold text-gray-900 mb-2">{{ __('messages.confirm_deletion_title') }}</h3>
                        <p class="text-sm text-gray-500 mb-6">{{ __('messages.confirm_deletion_text') }}</p>
                        
                        <form id="deleteForm" method="POST">
                            @csrf @method('DELETE')
                            <div class="flex gap-3">
                                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-sm text-xs uppercase tracking-widest transition-colors shadow-lg">
                                    {{ __('messages.confirm') }}
                                </button>
                                <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 rounded-sm text-xs uppercase tracking-widest transition-colors">
                                    {{ __('messages.cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function accessManager() {
            return {
                isOpen: false,
                loading: false,
                currentPropertyId: null,
                currentPropertyTitle: '',
                clients: [],
                allowedIds: [],

                openModal(propertyId, title) {
                    this.currentPropertyId = propertyId;
                    this.currentPropertyTitle = title;
                    this.isOpen = true;
                    this.loading = true;
                    
                    // Ajuste de rota para /imoveis/{id}/access-list
                    fetch(`/imoveis/${propertyId}/access-list`)
                        .then(res => res.json())
                        .then(data => {
                            this.clients = data.clients.data ? data.clients.data : data.clients;
                            this.allowedIds = data.allowed_ids;
                            this.loading = false;
                        });
                },

                closeModal() {
                    this.isOpen = false;
                    this.clients = [];
                },

                toggleAccess(clientId, isChecked) {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    // Ajuste de rota para /imoveis/{id}/access
                    fetch(`/imoveis/${this.currentPropertyId}/access`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ user_id: clientId, access: isChecked })
                    }).then(res => {
                        if(!res.ok) alert('{{ __('messages.error') }}');
                    });
                }
            }
        }

        function confirmDelete(propertyId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            // Atenção: a rota de delete também deve ser /imoveis/{id} para bater com routes/web.php
            form.action = `/imoveis/${propertyId}`; 
            modal.classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        // Fechar ao clicar fora
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            // Verifica se clicou no overlay (primeiro filho é o backdrop)
            if (e.target.classList.contains('fixed')) closeDeleteModal();
        });
    </script>
</x-app-layout>