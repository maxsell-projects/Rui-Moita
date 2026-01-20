@extends('layouts.admin')

@section('content')

{{-- Header da Página --}}
<div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
    <div>
        <h1 class="text-3xl md:text-4xl font-didot text-brand-primary">Portfólio</h1>
        <p class="text-gray-500 text-sm mt-2 font-light">Gerencie os seus ativos imobiliários exclusivos.</p>
    </div>
    
    <a href="{{ route('admin.properties.create') }}" class="bg-brand-cta text-white px-6 py-3 rounded shadow-md hover:bg-brand-primary hover:shadow-lg transition-all duration-300 uppercase text-[10px] font-bold tracking-widest flex items-center gap-2 transform hover:-translate-y-0.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Novo Imóvel
    </a>
</div>

{{-- Tabela de Imóveis --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[10px] uppercase tracking-widest text-gray-500 font-bold">
                    <th class="px-6 py-4 w-24">Capa</th>
                    <th class="px-6 py-4">Detalhes do Imóvel</th>
                    <th class="px-6 py-4">Valor</th>
                    <th class="px-6 py-4">Localização</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($properties as $property)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        
                        {{-- Imagem (Capa) --}}
                        <td class="px-6 py-4">
                            <div class="w-16 h-12 rounded bg-gray-100 overflow-hidden relative border border-gray-200 shadow-sm">
                                @if($property->cover_image)
                                    <img src="{{ asset('storage/' . $property->cover_image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Título e Tipo --}}
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.properties.edit', $property) }}" class="font-bold text-brand-primary group-hover:text-brand-cta transition-colors block mb-0.5">
                                {{ Str::limit($property->title, 45) }}
                            </a>
                            <span class="text-xs text-gray-400 font-light">{{ $property->type }}</span>
                        </td>

                        {{-- Preço --}}
                        <td class="px-6 py-4 font-serif text-gray-700 whitespace-nowrap">
                            @if($property->price)
                                {{ number_format($property->price, 0, ',', '.') }} €
                            @else
                                <span class="text-[10px] text-gray-400 uppercase tracking-wider">Sob Consulta</span>
                            @endif
                        </td>

                        {{-- Localização --}}
                        <td class="px-6 py-4 text-gray-500 font-light">
                            {{ $property->location }}
                        </td>

                        {{-- Status (Badges) --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1">
                                @if($property->is_visible)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-green-50 text-green-700 border border-green-100 uppercase tracking-wider">
                                        Visível
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-gray-100 text-gray-500 border border-gray-200 uppercase tracking-wider">
                                        Oculto
                                    </span>
                                @endif

                                @if($property->is_featured)
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-[9px] font-bold bg-brand-premium/10 text-brand-premium border border-brand-premium/20 uppercase tracking-wider w-full max-w-[60px]" title="Destaque na Home">
                                        ★ Top
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Ações --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-2">
                                {{-- Ver no Site --}}
                                <a href="{{ route('properties.show', $property->slug) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-brand-primary transition-colors" title="Ver no Site">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 5 8.268 7.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                
                                {{-- Editar --}}
                                <a href="{{ route('admin.properties.edit', $property) }}" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-brand-cta/10 text-gray-400 hover:text-brand-cta transition-colors" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                
                                {{-- Apagar --}}
                                <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar permanentemente este imóvel?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- Estado Vazio --}}
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <h3 class="text-lg font-didot text-gray-700">Nenhum imóvel encontrado</h3>
                                <p class="text-gray-400 text-sm font-light mt-1">O seu portfólio está vazio neste momento.</p>
                                <a href="{{ route('admin.properties.create') }}" class="mt-4 text-brand-cta hover:text-brand-primary text-xs font-bold uppercase tracking-widest border-b border-brand-cta hover:border-brand-primary pb-0.5 transition-all">
                                    Adicionar o primeiro imóvel
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginação --}}
<div class="mt-8">
    {{ $properties->links() }}
</div>

@endsection