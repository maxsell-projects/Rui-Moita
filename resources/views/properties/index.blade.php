<x-public-layout>
    
    {{-- 1. HEADER CORRETO (PARTIALS) --}}
    @include('partials.header')

    {{-- 2. HERO / "QUADRADO" (AUMENTADO) --}}
    {{-- Ajustei pt-44 e pb-28 para ficar mais alto e imponente --}}
    <section class="bg-intellectus-base pt-44 pb-28 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-3">
                <span class="text-xs font-bold uppercase tracking-widest text-intellectus-accent animate-fade-in-up">
                    {{ __('Real Estate') }}
                </span>
                <h1 class="font-serif text-4xl md:text-6xl text-white animate-fade-in-up delay-100">
                    {{ __('Exclusive Portfolio') }}
                </h1>
                <p class="text-white/60 text-base font-light max-w-2xl mt-4 animate-fade-in-up delay-200">
                    {{ __('Explore our curated selection of premium properties and investment opportunities.') }}
                </p>
            </div>
        </div>
    </section>

    {{-- CONTEÚDO PRINCIPAL --}}
    <div class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col lg:flex-row gap-8">
                
                {{-- SIDEBAR DE FILTROS --}}
                <aside class="w-full lg:w-1/4">
                    <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100 sticky top-32">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-intellectus-primary flex items-center gap-2">
                                <svg class="w-5 h-5 text-intellectus-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                {{ __('Filter') }}
                            </h3>
                            <a href="{{ route('properties.index') }}" class="text-xs text-gray-400 hover:text-intellectus-accent transition-colors">{{ __('Clear') }}</a>
                        </div>

                        <form method="GET" action="{{ route('properties.index') }}" class="space-y-6">
                            
                            {{-- Search --}}
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Search') }}</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Ref, City, Title...') }}" class="w-full rounded-sm border-gray-200 focus:border-intellectus-accent focus:ring-intellectus-accent text-sm placeholder-gray-300">
                            </div>

                            {{-- Transaction Type --}}
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Transaction') }}</label>
                                <div class="flex bg-gray-50 rounded-sm p-1 border border-gray-100">
                                    <label class="flex-1 text-center cursor-pointer">
                                        <input type="radio" name="transaction_type" value="sale" class="sr-only peer" {{ request('transaction_type') == 'sale' ? 'checked' : '' }}>
                                        <span class="block py-2 text-xs font-bold text-gray-400 rounded-sm peer-checked:bg-white peer-checked:text-intellectus-accent peer-checked:shadow-sm transition-all">{{ __('Buy') }}</span>
                                    </label>
                                    <label class="flex-1 text-center cursor-pointer">
                                        <input type="radio" name="transaction_type" value="rent" class="sr-only peer" {{ request('transaction_type') == 'rent' ? 'checked' : '' }}>
                                        <span class="block py-2 text-xs font-bold text-gray-400 rounded-sm peer-checked:bg-white peer-checked:text-intellectus-accent peer-checked:shadow-sm transition-all">{{ __('Rent') }}</span>
                                    </label>
                                </div>
                            </div>

                            {{-- City --}}
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('City') }}</label>
                                <select name="city" class="w-full rounded-sm border-gray-200 focus:border-intellectus-accent focus:ring-intellectus-accent text-sm text-gray-600">
                                    <option value="">{{ __('All Cities') }}</option>
                                    @foreach(['Lisboa','Porto','Cascais','Faro','Braga','Coimbra'] as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Property Type --}}
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Property Type') }}</label>
                                <select name="type" class="w-full rounded-sm border-gray-200 focus:border-intellectus-accent focus:ring-intellectus-accent text-sm text-gray-600">
                                    <option value="">{{ __('All Types') }}</option>
                                    @foreach(['apartment','house','villa','land','commercial','office'] as $type)
                                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ __(ucfirst($type)) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Price Range --}}
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Price Range') }}</label>
                                <div class="flex gap-2">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min €" class="w-full rounded-sm border-gray-200 focus:border-intellectus-accent focus:ring-intellectus-accent text-sm placeholder-gray-300">
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max €" class="w-full rounded-sm border-gray-200 focus:border-intellectus-accent focus:ring-intellectus-accent text-sm placeholder-gray-300">
                                </div>
                            </div>

                            {{-- Bedrooms --}}
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Bedrooms') }}</label>
                                <div class="flex gap-2">
                                    @foreach([1,2,3,4] as $bed)
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="bedrooms" value="{{ $bed }}" class="sr-only peer" {{ request('bedrooms') == $bed ? 'checked' : '' }}>
                                            <div class="py-2 text-center text-xs font-bold border border-gray-200 rounded-sm text-gray-400 peer-checked:border-intellectus-accent peer-checked:bg-intellectus-accent/5 peer-checked:text-intellectus-accent hover:border-gray-300 transition-all">
                                                {{ $bed }}+
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-intellectus-primary hover:bg-intellectus-base text-white font-bold py-3 rounded-sm transition-all shadow-md hover:shadow-lg uppercase tracking-widest text-xs">
                                {{ __('Apply Filters') }}
                            </button>
                        </form>
                    </div>
                </aside>

                {{-- LISTA DE PROPRIEDADES --}}
                <div class="flex-1">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <h2 class="text-2xl font-serif text-intellectus-primary">{{ __('Properties') }}</h2>
                            <div class="h-0.5 w-12 bg-intellectus-accent mt-2"></div>
                        </div>
                        <p class="text-gray-400 text-xs uppercase tracking-widest">{{ $properties->total() }} {{ __('results found') }}</p>
                    </div>

                    @if($properties->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($properties as $property)
                                <div class="bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:shadow-gray-200/50 transition-all duration-500 group h-full flex flex-col">
                                    {{-- Imagem --}}
                                    <div class="relative aspect-[4/3] overflow-hidden">
                                        <a href="{{ route('properties.show', $property) }}">
                                            @if($property->cover_image)
                                                <img src="{{ Storage::url($property->cover_image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                            @elseif($property->images && count($property->images) > 0)
                                                <img src="{{ Storage::url($property->images[0]) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                            @else
                                                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                    <span class="text-gray-300 text-xs uppercase tracking-widest">{{ __('No Image') }}</span>
                                                </div>
                                            @endif
                                        </a>
                                        
                                        {{-- Badges --}}
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-white/95 backdrop-blur-sm text-intellectus-primary px-3 py-1 rounded-sm text-[10px] font-bold uppercase tracking-widest shadow-sm border border-gray-100">
                                                {{ __(ucfirst($property->type)) }}
                                            </span>
                                        </div>

                                        @if($property->is_exclusive)
                                            <div class="absolute top-4 right-4">
                                                <span class="bg-intellectus-accent text-white px-3 py-1 rounded-sm text-[10px] font-bold uppercase tracking-widest shadow-sm">
                                                    {{ __('Off-Market') }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Conteúdo Card --}}
                                    <div class="p-5 flex flex-col flex-1">
                                        <div class="mb-3">
                                            <p class="text-intellectus-accent text-[10px] uppercase tracking-widest font-bold mb-1 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                {{ $property->city }}
                                            </p>
                                            <h3 class="text-lg font-serif text-intellectus-primary line-clamp-1 group-hover:text-intellectus-accent transition-colors">
                                                <a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a>
                                            </h3>
                                        </div>

                                        <div class="flex items-center gap-4 text-xs text-gray-500 mb-6 mt-auto border-t border-gray-50 pt-3">
                                            <span class="flex items-center gap-1"><span class="font-bold text-gray-700">{{ $property->bedrooms }}</span> {{ __('Bedrooms') }}</span>
                                            <span class="w-px h-3 bg-gray-200"></span>
                                            <span class="flex items-center gap-1"><span class="font-bold text-gray-700">{{ $property->area }}</span> m²</span>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <span class="text-lg font-serif text-intellectus-primary">{{ $property->formatted_price }}</span>
                                            <a href="{{ route('properties.show', $property) }}" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-intellectus-primary hover:text-white hover:border-intellectus-primary transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-12">
                            {{ $properties->links() }}
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-24 bg-white rounded-sm border border-gray-100 shadow-sm flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mb-4 text-gray-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-serif text-intellectus-primary mb-2">{{ __('No properties found') }}</h3>
                            <p class="text-gray-500 text-sm font-light max-w-xs mx-auto mb-6">{{ __('Try adjusting your filters.') }}</p>
                            <a href="{{ route('properties.index') }}" class="px-6 py-3 border border-intellectus-primary text-intellectus-primary text-xs font-bold uppercase tracking-widest hover:bg-intellectus-primary hover:text-white transition-all">
                                {{ __('Clear Filters') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Footer removido daqui pois já está no Layout Public --}}

</x-public-layout>