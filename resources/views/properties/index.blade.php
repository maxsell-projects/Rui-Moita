@extends('layouts.app')

@section('title', 'Coleção Privada | Marco Moura')

@section('content')

{{-- HERO SECTION: EDITORIAL (Verde Inglês) --}}
<section class="bg-brand-secondary text-white py-32 text-center relative overflow-hidden">
    {{-- Padrão de Fundo Sutil --}}
    <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    <div class="container mx-auto px-6 relative z-10" data-aos="fade-up">
        <p class="text-brand-sand font-mono text-xs uppercase tracking-[0.4em] mb-6 flex justify-center items-center gap-3">
            <span class="w-6 h-[1px] bg-brand-sand"></span>
            Portfólio Exclusivo
            <span class="w-6 h-[1px] bg-brand-sand"></span>
        </p>
        <h1 class="text-5xl md:text-7xl font-serif leading-tight mb-4">
            Encontre o Seu <span class="italic text-brand-sand">Legado.</span>
        </h1>
    </div>
</section>

<section class="py-20 bg-brand-background text-brand-text min-h-screen">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            
            {{-- SIDEBAR DE FILTROS (Sticky) --}}
            <aside class="lg:col-span-1">
                <div class="bg-white p-8 shadow-xl border-t-4 border-brand-primary sticky top-32" data-aos="fade-right">
                    <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                        <h3 class="font-serif text-xl text-brand-secondary">Refinar Busca</h3>
                        <a href="{{ route('portfolio') }}" class="text-[10px] text-gray-400 uppercase hover:text-brand-primary tracking-widest transition-colors">
                            Limpar
                        </a>
                    </div>
                    
                    <form action="{{ route('portfolio') }}" method="GET" class="space-y-6">
                        
                        {{-- Busca Livre --}}
                        <div class="group">
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-secondary mb-2 block">Localização</label>
                            <div class="relative">
                                <input type="text" name="location" value="{{ request('location') }}" placeholder="Ex: Estoril, Chiado..." 
                                       class="w-full bg-brand-background border-b border-gray-200 px-0 py-3 text-sm focus:outline-none focus:border-brand-primary transition-colors placeholder-gray-400 text-brand-primary font-light">
                                <svg class="w-4 h-4 text-gray-400 absolute right-0 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                        </div>

                        {{-- Tipo --}}
                        <div>
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-secondary mb-2 block">Tipo de Imóvel</label>
                            <select name="type" class="w-full bg-brand-background border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-brand-primary text-gray-600 appearance-none rounded-none">
                                <option value="">Todos os Tipos</option>
                                <option value="Apartamento" {{ request('type') == 'Apartamento' ? 'selected' : '' }}>Apartamento</option>
                                <option value="Moradia" {{ request('type') == 'Moradia' ? 'selected' : '' }}>Moradia / Villa</option>
                                <option value="Terreno" {{ request('type') == 'Terreno' ? 'selected' : '' }}>Terreno</option>
                                <option value="Comercial" {{ request('type') == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                            </select>
                        </div>

                        {{-- Finalidade --}}
                        <div>
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-secondary mb-3 block">Objetivo</label>
                            <div class="flex gap-6">
                                <label class="flex items-center text-sm text-gray-600 gap-2 cursor-pointer group">
                                    <div class="relative flex items-center">
                                        <input type="radio" name="status" value="Venda" {{ request('status') == 'Venda' ? 'checked' : '' }} class="peer sr-only">
                                        <div class="w-4 h-4 border border-gray-300 rounded-full peer-checked:border-brand-primary peer-checked:bg-brand-primary transition-all"></div>
                                    </div>
                                    <span class="group-hover:text-brand-primary transition-colors text-xs uppercase tracking-wider">Comprar</span>
                                </label>
                                <label class="flex items-center text-sm text-gray-600 gap-2 cursor-pointer group">
                                    <div class="relative flex items-center">
                                        <input type="radio" name="status" value="Arrendamento" {{ request('status') == 'Arrendamento' ? 'checked' : '' }} class="peer sr-only">
                                        <div class="w-4 h-4 border border-gray-300 rounded-full peer-checked:border-brand-primary peer-checked:bg-brand-primary transition-all"></div>
                                    </div>
                                    <span class="group-hover:text-brand-primary transition-colors text-xs uppercase tracking-wider">Arrendar</span>
                                </label>
                            </div>
                        </div>

                        {{-- Preço --}}
                        <div>
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-secondary mb-2 block">Investimento (€)</label>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Min" 
                                       class="w-full bg-brand-background border border-gray-200 px-3 py-3 text-sm focus:border-brand-primary outline-none transition-colors placeholder-gray-400 font-light">
                                <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Max" 
                                       class="w-full bg-brand-background border border-gray-200 px-3 py-3 text-sm focus:border-brand-primary outline-none transition-colors placeholder-gray-400 font-light">
                            </div>
                        </div>

                        {{-- Quartos --}}
                        <div>
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-secondary mb-2 block">Tipologia (Quartos)</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['1', '2', '3', '4+'] as $bed)
                                    <label class="cursor-pointer flex-1">
                                        <input type="radio" name="bedrooms" value="{{ $bed }}" {{ request('bedrooms') == $bed ? 'checked' : '' }} class="peer sr-only">
                                        <span class="block w-full py-2 text-center border border-gray-200 text-sm peer-checked:bg-brand-primary peer-checked:text-white peer-checked:border-brand-primary hover:border-brand-primary hover:text-brand-primary transition-all text-gray-500 font-serif">
                                            {{ $bed }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-brand-primary text-white font-bold uppercase tracking-[0.2em] text-xs py-4 hover:bg-brand-secondary transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                            Atualizar Resultados
                        </button>
                    </form>
                </div>
            </aside>

            {{-- GRID DE IMÓVEIS --}}
            <div class="lg:col-span-3">
                <div class="flex justify-between items-end mb-8 border-b border-gray-200 pb-4">
                    <div>
                        <h2 class="font-serif text-3xl text-brand-secondary">Resultados</h2>
                        <p class="text-gray-500 text-xs mt-1 uppercase tracking-widest">{{ $properties->total() }} imóveis exclusivos</p>
                    </div>
                    
                    {{-- Ordenação --}}
                    <div class="hidden md:flex items-center gap-2 text-xs uppercase tracking-widest text-gray-400">
                        <span>Ordenar:</span>
                        <select class="bg-transparent border-none text-brand-primary font-bold focus:ring-0 cursor-pointer text-xs uppercase tracking-widest p-0">
                            <option>Recentes</option>
                            <option>Valor (Maior)</option>
                            <option>Valor (Menor)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($properties as $property)
                        <div class="group bg-white flex flex-col h-full shadow-sm hover:shadow-2xl transition-all duration-500" data-aos="fade-up">
                            
                            {{-- Capa --}}
                            <div class="relative h-72 overflow-hidden">
                                <a href="{{ route('properties.show', $property->slug) }}" class="block h-full w-full">
                                    <div class="absolute inset-0 bg-brand-secondary/10 opacity-0 group-hover:opacity-100 transition-opacity z-10 duration-500"></div>
                                    <img src="{{ $property->cover_image ? asset('storage/' . $property->cover_image) : asset('img/placeholder.jpg') }}" 
                                         alt="{{ $property->title }}" 
                                         loading="lazy"
                                         class="w-full h-full object-cover transform group-hover:scale-105 transition duration-[1.5s] ease-out">
                                </a>
                                
                                {{-- Badges --}}
                                <div class="absolute top-4 left-4 flex flex-col gap-2 z-20">
                                    <span class="bg-white/90 backdrop-blur text-brand-secondary text-[10px] uppercase tracking-widest px-3 py-1 font-bold">
                                        {{ $property->type }}
                                    </span>
                                    @if($property->is_featured)
                                        <span class="bg-brand-sand text-brand-secondary text-[10px] uppercase tracking-widest px-3 py-1 font-bold">
                                            Coleção Privada
                                        </span>
                                    @endif
                                </div>

                                {{-- Preço (Design Novo) --}}
                                <div class="absolute bottom-0 right-0 bg-brand-primary text-white px-5 py-3 font-serif text-lg z-20 shadow-lg">
                                    {{ $property->price ? number_format($property->price, 0, ',', '.') . ' €' : 'Sob Consulta' }}
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="p-6 flex flex-col flex-grow border border-gray-100 border-t-0 bg-white relative z-20">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-brand-sand flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-brand-sand"></span>
                                        {{ $property->location ?? 'Portugal' }}
                                    </span>
                                </div>

                                <h3 class="text-xl font-serif text-brand-secondary mb-4 leading-tight group-hover:text-brand-primary transition-colors">
                                    <a href="{{ route('properties.show', $property->slug) }}">
                                        {{ $property->title }}
                                    </a>
                                </h3>

                                <p class="text-gray-500 text-xs font-light line-clamp-2 mb-6 leading-relaxed">
                                    {{ $property->description }}
                                </p>

                                <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400 font-mono">
                                    @if($property->bedrooms)
                                        <span class="flex items-center gap-2" title="Quartos">
                                            {{ $property->bedrooms }} Quartos
                                        </span>
                                    @endif
                                    
                                    @if($property->area_gross)
                                        <span class="flex items-center gap-2" title="Área Bruta">
                                            {{ number_format($property->area_gross, 0) }} m²
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-24 bg-white border border-dashed border-gray-300">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <h3 class="font-serif text-xl text-brand-secondary mb-2">Sem Resultados</h3>
                            <p class="text-gray-500 mb-6 text-sm font-light">Não encontramos imóveis com os critérios definidos no Private Office.</p>
                            <a href="{{ route('portfolio') }}" class="inline-block px-8 py-3 bg-brand-secondary text-white text-xs font-bold uppercase tracking-widest hover:bg-brand-primary transition-colors">
                                Ver Coleção Completa
                            </a>
                        </div>
                    @endforelse
                </div>

                <div class="mt-16">
                    {{ $properties->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection