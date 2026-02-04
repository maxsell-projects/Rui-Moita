@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Cabeçalho da Página --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-serif text-intellectus-primary font-bold">
                    {{ __('messages.pending_requests') }}
                </h2>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm border border-gray-100">
                <div class="p-0"> {{-- Removido padding para a tabela encostar nas bordas --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-intellectus-surface">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.requester') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.type') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.investment') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.date') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.status') }}</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($requests as $request)
                                <tr class="hover:bg-gray-50 transition-colors cursor-pointer group" onclick="window.location='{{ route('admin.access-requests.show', $request) }}'">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($request->user)
                                            <div class="text-sm font-bold font-serif text-intellectus-primary">{{ $request->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $request->user->email }}</div>
                                            <span class="mt-1 inline-flex text-[9px] uppercase tracking-widest font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-sm border border-blue-100">{{ __('messages.existing_user') }}</span>
                                        @else
                                            <div class="text-sm font-bold font-serif text-intellectus-primary">{{ $request->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $request->email }}</div>
                                            <span class="mt-1 inline-flex text-[9px] uppercase tracking-widest font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-sm border border-green-100">{{ __('messages.new_user') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-sm bg-intellectus-surface text-intellectus-primary border border-gray-200">
                                            {{ ucfirst($request->investor_type ?? $request->requested_role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-serif text-intellectus-primary">{{ $request->investment_amount ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-mono">
                                        {{ $request->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($request->status === 'pending')
                                            <span class="px-2 py-1 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-sm bg-yellow-50 text-yellow-700 border border-yellow-200">{{ __('messages.pending') }}</span>
                                        @elseif($request->status === 'approved')
                                            <span class="px-2 py-1 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-sm bg-green-50 text-green-700 border border-green-200">{{ __('messages.approved') }}</span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-sm bg-red-50 text-red-700 border border-red-200">{{ __('messages.rejected') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.access-requests.show', $request) }}" class="text-intellectus-accent group-hover:text-intellectus-primary font-bold text-xs uppercase tracking-widest transition-colors">
                                            {{ __('messages.review') }} &rarr;
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-xs uppercase tracking-widest">
                                        {{ __('messages.no_requests') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($requests->hasPages())
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                            {{ $requests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection