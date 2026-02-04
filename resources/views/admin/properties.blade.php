@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-serif font-bold text-intellectus-primary">{{ __('messages.property_management') }}</h2>
                    <p class="text-sm text-gray-500 font-light mt-1">{{ __('Manage your exclusive portfolio.') }}</p>
                </div>
                <a href="{{ route('properties.create') }}" class="inline-flex items-center px-4 py-2 bg-intellectus-accent text-intellectus-base rounded-sm shadow-sm text-xs font-bold uppercase tracking-widest hover:bg-intellectus-primary hover:text-white transition-all duration-300">
                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('messages.new_property') }}
                </a>
            </div>
            
            {{-- Filtros --}}
            <div class="bg-white p-4 rounded-sm mb-6 border border-gray-100 shadow-sm">
                <form method="GET" action="{{ route('admin.properties.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_placeholder') }}" 
                           class="flex-1 border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 text-sm py-2 px-0 bg-transparent placeholder-gray-400 transition-colors">
                    
                    <select name="status" class="border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 text-sm py-2 px-0 bg-transparent text-gray-600 transition-colors w-full sm:w-48">
                        <option value="">{{ __('messages.status') }} (Todos)</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('Pending Review') }}</option>
                        <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>{{ __('Sold') }}</option>
                    </select>
                    
                    <button type="submit" class="bg-intellectus-primary text-white px-6 py-2 rounded-sm text-xs font-bold uppercase tracking-widest hover:bg-intellectus-accent transition-colors">
                        {{ __('messages.filter') }}
                    </button>
                </form>
            </div>

            {{-- Tabela --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm border border-gray-100">
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-intellectus-surface">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.property') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.location') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.status') }}</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.owner') }}</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($properties as $property)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-sm overflow-hidden border border-gray-200">
                                                @if($property->cover_image)
                                                    <img class="h-full w-full object-cover" src="{{ Storage::url($property->cover_image) }}" alt="">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-gray-300">
                                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold font-serif text-intellectus-primary group-hover:text-intellectus-accent transition-colors">{{ $property->title }}</div>
                                                <div class="text-xs text-gray-500">{{ $property->type }} • {{ $property->formatted_price }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $property->city }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($property->status === 'active')
                                            <span class="px-2 py-1 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-sm bg-green-50 text-green-700 border border-green-200">{{ __('messages.active') }}</span>
                                        @elseif($property->status === 'pending')
                                            <span class="px-2 py-1 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-sm bg-yellow-50 text-yellow-700 border border-yellow-200">{{ __('Pending') }}</span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-sm bg-gray-100 text-gray-600 border border-gray-200">{{ ucfirst($property->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $property->user->name ?? 'Admin' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('properties.edit', $property) }}" class="text-intellectus-primary hover:text-intellectus-accent transition-colors" title="{{ __('Edit') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this property?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" title="{{ __('Delete') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-xs uppercase tracking-widest text-gray-400">
                                        {{ __('messages.no_properties') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($properties->hasPages())
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                            {{ $properties->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection