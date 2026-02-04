@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Cabeçalho --}}
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-serif font-bold text-intellectus-primary">{{ __('messages.wallet_requests_title') }}</h2>
                    <p class="text-sm text-gray-500 font-light mt-1">{{ __('messages.wallet_requests_subtitle') }}</p>
                </div>
            </div>

            {{-- Mensagens de Sucesso --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 shadow-sm mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm border border-gray-100">
                <div class="p-0"> {{-- Padding zero para tabela full-width --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-intellectus-surface">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.builder_requester') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.client_to_add') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.date') }}</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($pendingClients as $client)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold font-serif text-intellectus-primary">{{ $client->developer->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $client->developer->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-intellectus-surface text-intellectus-primary border border-gray-200 flex items-center justify-center font-bold text-xs mr-3">
                                                {{ substr($client->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-intellectus-primary">{{ $client->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $client->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                        {{ $client->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <form action="{{ route('admin.exclusive-requests.approve', $client) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-[10px] font-bold uppercase tracking-widest py-2 px-3 rounded-sm transition-colors shadow-sm flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    {{ __('messages.approve_entry') }}
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.exclusive-requests.reject', $client) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_refuse') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-white border border-red-200 text-red-600 hover:bg-red-50 text-[10px] font-bold uppercase tracking-widest py-2 px-3 rounded-sm transition-colors">
                                                    {{ __('messages.refuse') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-xs uppercase tracking-widest text-gray-400">
                                        {{ __('messages.no_requests') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($pendingClients->hasPages())
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                            {{ $pendingClients->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection