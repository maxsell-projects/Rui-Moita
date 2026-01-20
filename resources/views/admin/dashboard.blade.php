@extends('layouts.admin')

@section('content')

{{-- HEADER & AÇÕES --}}
<div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
    <div>
        <h1 class="text-3xl md:text-4xl font-serif text-brand-secondary">Visão Geral</h1>
        <p class="text-gray-500 text-sm mt-2 font-light">
            Bem-vindo de volta, <span class="font-bold text-brand-primary">{{ Auth::user()->name ?? 'Administrador' }}</span>.
        </p>
    </div>
    
    <a href="{{ route('admin.properties.create') }}" 
       class="bg-brand-primary text-white px-6 py-3 rounded-sm shadow-md hover:bg-brand-secondary hover:shadow-lg transition-all duration-300 uppercase text-[10px] font-bold tracking-widest flex items-center gap-2 transform hover:-translate-y-0.5 border border-transparent hover:border-brand-sand">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
        Novo Ativo
    </a>
</div>

{{-- ESTATÍSTICAS (KPIs) --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    
    {{-- Card 1: Total --}}
    <div class="bg-white p-8 rounded-sm shadow-sm border-l-4 border-brand-secondary flex items-center justify-between group hover:shadow-md transition-all">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">Portfólio Total</p>
            <p class="text-4xl font-serif text-brand-secondary group-hover:text-brand-primary transition-colors">
                {{ \App\Models\Property::count() }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-full bg-brand-secondary/5 flex items-center justify-center text-brand-secondary group-hover:bg-brand-secondary group-hover:text-white transition-all duration-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
    </div>

    {{-- Card 2: Venda --}}
    <div class="bg-white p-8 rounded-sm shadow-sm border-l-4 border-brand-primary flex items-center justify-between group hover:shadow-md transition-all">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">Para Venda</p>
            <p class="text-4xl font-serif text-brand-primary">
                {{ \App\Models\Property::where('status', 'available')->orWhere('status', 'Venda')->count() }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-full bg-brand-primary/5 flex items-center justify-center text-brand-primary group-hover:bg-brand-primary group-hover:text-white transition-all duration-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>

    {{-- Card 3: Arrendamento (Azul Profundo - Marco Moura Style) --}}
    <div class="bg-white p-8 rounded-sm shadow-sm border-l-4 border-slate-600 flex items-center justify-between group hover:shadow-md transition-all">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">Arrendamento</p>
            <p class="text-4xl font-serif text-slate-700">
                {{ \App\Models\Property::where('status', 'Arrendamento')->count() }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-600 group-hover:bg-slate-600 group-hover:text-white transition-all duration-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
    </div>
</div>

{{-- TABELA DE ÚLTIMAS ADIÇÕES --}}
<div class="bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="font-serif text-lg text-brand-secondary">Últimas Adições</h3>
        <a href="{{ route('admin.properties.index') }}" class="text-[10px] uppercase tracking-widest font-bold text-brand-primary hover:text-brand-secondary transition-colors flex items-center gap-2 group">
            Ver Todos
            <span class="group-hover:translate-x-1 transition-transform">→</span>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left whitespace-nowrap">
            <thead class="bg-white border-b border-gray-100 text-[9px] uppercase text-gray-400 font-bold tracking-widest">
                <tr>
                    <th class="px-8 py-5">Imóvel</th>
                    <th class="px-6 py-5">Valor</th>
                    <th class="px-6 py-5">Localização</th>
                    <th class="px-6 py-5 text-center">Estado</th>
                    <th class="px-8 py-5 text-right">Ação</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @forelse(\App\Models\Property::latest()->take(5)->get() as $property)
                <tr class="hover:bg-gray-50 transition-colors group">
                    {{-- Imagem + Nome --}}
                    <td class="px-8 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 overflow-hidden flex-shrink-0 border border-gray-200">
                                @if($property->cover_image)
                                    <img src="{{ asset('storage/'.$property->cover_image) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('admin.properties.edit', $property) }}" class="font-bold text-brand-secondary group-hover:text-brand-primary transition-colors block font-serif text-base">
                                    {{ Str::limit($property->title, 30) }}
                                </a>
                                <p class="text-[9px] text-gray-400 uppercase tracking-widest font-mono mt-1">{{ $property->reference_code ?? 'SEM REF' }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Preço --}}
                    <td class="px-6 py-4 font-serif text-brand-secondary text-base">
                        {{ $property->price ? number_format($property->price, 0, ',', '.') . ' €' : 'Sob Consulta' }}
                    </td>

                    {{-- Localização --}}
                    <td class="px-6 py-4 text-gray-500 font-light text-xs uppercase tracking-wide">{{ $property->location }}</td>

                    {{-- Estado --}}
                    <td class="px-6 py-4 text-center">
                        @if($property->is_visible)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-sm text-[9px] font-bold bg-green-50 text-green-800 border border-green-100 uppercase tracking-widest">
                                Visível
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-sm text-[9px] font-bold bg-gray-100 text-gray-500 border border-gray-200 uppercase tracking-widest">
                                Oculto
                            </span>
                        @endif
                    </td>

                    {{-- Ação --}}
                    <td class="px-8 py-4 text-right">
                        <a href="{{ route('admin.properties.edit', $property) }}" class="p-2 text-gray-400 hover:text-brand-primary hover:bg-brand-primary/5 rounded-full transition-colors inline-flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 text-sm font-light">
                        Ainda não existem imóveis registados no sistema.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection