@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto mb-8 px-6">
        
        {{-- Banner de Boas-Vindas --}}
        <div class="bg-gradient-to-r from-intellectus-base to-intellectus-primary rounded-sm p-8 shadow-2xl text-white relative overflow-hidden border border-intellectus-primary/50 mt-8">
            {{-- Efeito de Fundo --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-intellectus-accent opacity-10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <div class="relative z-10 md:flex md:items-center md:justify-between">
                <div>
                    <h2 class="text-3xl font-serif leading-tight mb-2">
                        {{ __('Welcome back, :name', ['name' => Auth::user()->name]) }}
                    </h2>
                    <p class="text-gray-300 text-sm font-sans uppercase tracking-widest">{{ __('Private Office Overview') }}</p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 gap-3">
                    <a href="{{ route('properties.create') }}" class="inline-flex items-center px-4 py-3 bg-intellectus-accent text-intellectus-base rounded-sm shadow-lg text-xs font-bold uppercase tracking-widest hover:bg-white hover:text-intellectus-accent transition-all duration-300">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        {{ __('New Property') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Grid de Estatísticas --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mt-8">
            
            {{-- Card 1: Properties Pending --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-intellectus-surface rounded-full p-3 group-hover:bg-intellectus-primary transition-colors duration-300">
                            <svg class="h-6 w-6 text-intellectus-primary group-hover:text-intellectus-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </div>
                        @if($stats['pending_properties'] > 0)
                            <span class="text-[10px] font-bold uppercase text-white bg-orange-500 px-2 py-1 rounded-sm animate-pulse">{{ __('Action Needed') }}</span>
                        @endif
                    </div>
                    <div class="text-3xl font-serif text-intellectus-primary mb-1">{{ $stats['pending_properties'] }}</div>
                    <div class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">{{ __('Properties Under Review') }}</div>
                </div>
                <a href="{{ route('admin.properties.pending') }}" class="block bg-intellectus-surface px-6 py-3 text-[10px] uppercase tracking-widest text-intellectus-primary font-bold hover:bg-intellectus-primary hover:text-white transition-colors">
                    {{ __('Review') }} &rarr;
                </a>
            </div>

            {{-- Card 2: Access Requests --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-intellectus-surface rounded-full p-3 group-hover:bg-intellectus-primary transition-colors duration-300">
                            <svg class="h-6 w-6 text-intellectus-primary group-hover:text-intellectus-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        @if($stats['pending_requests'] > 0)
                            <span class="text-[10px] font-bold uppercase text-white bg-intellectus-accent px-2 py-1 rounded-sm">{{ __('New') }}</span>
                        @endif
                    </div>
                    <div class="text-3xl font-serif text-intellectus-primary mb-1">{{ $stats['pending_requests'] }}</div>
                    <div class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">{{ __('Pending Requests') }}</div>
                </div>
                <a href="{{ route('admin.access-requests') }}" class="block bg-intellectus-surface px-6 py-3 text-[10px] uppercase tracking-widest text-intellectus-primary font-bold hover:bg-intellectus-primary hover:text-white transition-colors">
                    {{ __('View All') }} &rarr;
                </a>
            </div>

            {{-- Card 3: Developers / Partners --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-intellectus-surface rounded-full p-3 group-hover:bg-intellectus-primary transition-colors duration-300">
                            <svg class="h-6 w-6 text-intellectus-primary group-hover:text-intellectus-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        @if($stats['exclusive_pending'] > 0)
                            <span class="text-[10px] font-bold uppercase text-intellectus-primary bg-blue-100 px-2 py-1 rounded-sm">{{ $stats['exclusive_pending'] }} {{ __('pending') }}</span>
                        @endif
                    </div>
                    <div class="text-3xl font-serif text-intellectus-primary mb-1">{{ $stats['developers'] }}</div>
                    <div class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">{{ __('Partners (Devs)') }}</div>
                </div>
                <a href="{{ route('admin.exclusive-requests') }}" class="block bg-intellectus-surface px-6 py-3 text-[10px] uppercase tracking-widest text-intellectus-muted font-bold hover:bg-intellectus-primary hover:text-white transition-colors">
                    {{ __('Manage Wallets') }} &rarr;
                </a>
            </div>

            {{-- Card 4: Clients --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-intellectus-surface rounded-full p-3 group-hover:bg-intellectus-primary transition-colors duration-300">
                            <svg class="h-6 w-6 text-intellectus-primary group-hover:text-intellectus-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-serif text-intellectus-primary mb-1">{{ $stats['clients'] }}</div>
                    <div class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">{{ __('Total Investors') }}</div>
                </div>
                <div class="block bg-intellectus-surface px-6 py-3 text-[10px] uppercase tracking-widest text-intellectus-muted font-bold cursor-default">
                    {{ __('Global Database') }}
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
            
            {{-- Tabela de Pedidos de Acesso Recentes --}}
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm rounded-sm border border-gray-100 h-full overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-intellectus-surface">
                        <h3 class="text-lg font-serif text-intellectus-primary">{{ __('New Access Requests') }}</h3>
                        @if($stats['pending_requests'] > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-intellectus-accent text-white animate-pulse">
                                {{ $stats['pending_requests'] }} {{ __('new') }}
                            </span>
                        @endif
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-[10px] uppercase tracking-widest font-bold text-gray-400">{{ __('Requester') }}</th>
                                    <th class="px-6 py-3 text-left text-[10px] uppercase tracking-widest font-bold text-gray-400">{{ __('Type') }}</th>
                                    <th class="px-6 py-3 text-right text-[10px] uppercase tracking-widest font-bold text-gray-400">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($recentRequests as $request)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold font-serif text-intellectus-primary">{{ $request->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $request->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-sm bg-intellectus-surface text-intellectus-primary border border-gray-200">
                                            {{ ucfirst($request->investor_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.access-requests.show', $request) }}" class="text-intellectus-accent hover:text-intellectus-primary text-xs font-bold uppercase tracking-widest transition-colors">{{ __('Review') }}</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-400 text-xs uppercase tracking-widest">
                                        {{ __('All clear! No pending items.') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Lista de Imóveis Recentes --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white shadow-sm rounded-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-intellectus-surface">
                        <h3 class="text-lg font-serif text-intellectus-primary">{{ __('Latest Properties') }}</h3>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @forelse($recentProperties as $property)
                        <li>
                            <a href="{{ route('properties.show', $property) }}" class="block hover:bg-gray-50 transition-colors group">
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-serif font-bold text-intellectus-primary group-hover:text-intellectus-accent truncate transition-colors">{{ Str::limit($property->title, 25) }}</p>
                                        <span class="px-2 inline-flex text-[9px] font-bold uppercase tracking-widest rounded-sm {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $property->status === 'active' ? __('Active') : ucfirst($property->status) }}
                                        </span>
                                    </div>
                                    <div class="mt-2 text-xs text-gray-500">
                                        {{ $property->city }} • {{ $property->formatted_price }}
                                    </div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="px-6 py-8 text-center text-xs text-gray-400 uppercase tracking-widest">
                            {{ __('No properties registered.') }}
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection