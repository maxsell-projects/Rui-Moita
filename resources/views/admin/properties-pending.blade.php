@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Cabeçalho --}}
            <div class="mb-6 flex justify-between items-end">
                <div>
                    <h2 class="text-2xl font-bold text-intellectus-primary font-serif">{{ __('Properties Pending Review') }}</h2>
                    <p class="text-gray-500 text-sm mt-1 font-light">{{ __('Review and approve properties submitted by partners.') }}</p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-sm border border-gray-100 overflow-hidden">
                @if($properties->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-intellectus-surface">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('Property') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('Owner') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('Price') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('Submitted') }}</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($properties as $property)
                                    <tr class="hover:bg-gray-50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-16 w-24 flex-shrink-0 overflow-hidden rounded-sm bg-gray-100 border border-gray-200 relative">
                                                    @if($property->cover_image)
                                                        <img class="h-full w-full object-cover" src="{{ Storage::url($property->cover_image) }}" alt="">
                                                    @else
                                                        <div class="flex h-full w-full items-center justify-center text-gray-300">
                                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold font-serif text-intellectus-primary group-hover:text-intellectus-accent transition-colors">{{ $property->title }}</div>
                                                    <div class="text-xs text-gray-500">{{ $property->city }}</div>
                                                    @if($property->is_exclusive)
                                                        <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded-sm text-[9px] font-bold uppercase tracking-widest bg-intellectus-accent/10 text-intellectus-accent">
                                                            {{ __('Exclusive') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-intellectus-primary">{{ $property->user?->name ?? 'User Removed' }}</div>
                                            <div class="text-xs text-gray-500">{{ $property->user?->email ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold font-serif text-intellectus-primary">{{ $property->formatted_price }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $property->created_at->format('d/m/Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $property->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end items-center gap-2">
                                                {{-- Ver Detalhes --}}
                                                <a href="{{ route('properties.show', $property) }}" target="_blank" class="p-2 text-gray-400 hover:text-intellectus-accent hover:bg-gray-50 rounded-full transition-all" title="{{ __('View Details') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                </a>
                                                
                                                {{-- Aprovar --}}
                                                <form action="{{ route('admin.properties.approve-listing', $property) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="p-2 text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition-colors" title="{{ __('Approve') }}" onclick="return confirm('{{ __('Are you sure you want to approve this property?') }}')">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    </button>
                                                </form>

                                                {{-- Rejeitar --}}
                                                <form action="{{ route('admin.properties.reject-listing', $property) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="{{ __('Reject') }}" onclick="return confirm('{{ __('Are you sure you want to reject this property?') }}')">
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
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $properties->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 mb-4">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-intellectus-primary font-serif">{{ __('All clear! No pending items.') }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ __('No pending properties to review.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection