<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-graphite leading-tight font-heading">
            {{ __('Moderation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-end">
                <div>
                    <h3 class="text-2xl font-bold text-graphite font-heading">{{ __('Properties Pending Review') }}</h3>
                    <p class="text-gray-500">{{ __('Review and approve properties submitted by partners.') }}</p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                @if($properties->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Property') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Owner') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Price') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Submitted') }}</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($properties as $property)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-16 w-24 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100 border border-gray-200">
                                                    @if($property->cover_image)
                                                        <img class="h-full w-full object-cover" src="{{ Storage::url($property->cover_image) }}" alt="">
                                                    @else
                                                        <div class="flex h-full w-full items-center justify-center text-gray-400">
                                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-graphite">{{ $property->title }}</div>
                                                    <div class="text-xs text-gray-500">{{ $property->city }}</div>
                                                    @if($property->is_exclusive)
                                                        <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-accent/10 text-accent">
                                                            {{ __('Exclusive') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{-- FIX: Proteção contra null e user deletado --}}
                                            <div class="text-sm text-gray-900">{{ $property->user?->name ?? 'Usuário Removido' }}</div>
                                            <div class="text-xs text-gray-500">{{ $property->user?->email ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-graphite">{{ $property->formatted_price }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $property->created_at->format('d/m/Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $property->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end items-center gap-2">
                                                <a href="{{ route('properties.show', $property) }}" target="_blank" class="text-gray-400 hover:text-accent p-2" title="{{ __('View Details') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                </a>
                                                
                                                {{-- FIX: Corrigido nomes das rotas para bater com web.php --}}
                                                <form action="{{ route('admin.properties.approve-listing', $property) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH') {{-- Adicionado PATCH pois a rota é PATCH --}}
                                                    <button type="submit" class="text-green-600 hover:text-green-800 p-2 bg-green-50 rounded-lg hover:bg-green-100 transition-colors" title="{{ __('Approve') }}" onclick="return confirm('{{ __('Are you sure you want to approve this property?') }}')">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.properties.reject-listing', $property) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH') {{-- Adicionado PATCH pois a rota é PATCH --}}
                                                    <button type="submit" class="text-red-600 hover:text-red-800 p-2 bg-red-50 rounded-lg hover:bg-red-100 transition-colors" title="{{ __('Reject') }}" onclick="return confirm('{{ __('Are you sure you want to reject this property?') }}')">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $properties->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 mb-4">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-graphite">{{ __('All clear! No pending items.') }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ __('No pending properties.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>