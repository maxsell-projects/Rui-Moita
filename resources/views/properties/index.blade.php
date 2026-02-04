<x-public-layout>
    @include('components.header')

    <main class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
            
            <div class="flex flex-col lg:flex-row gap-8">
                
                <aside class="w-full lg:w-1/4">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-32">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-graphite flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                {{ __('Filter') }}
                            </h3>
                            <a href="{{ route('properties.index') }}" class="text-xs text-gray-500 hover:text-accent">{{ __('Clear') }}</a>
                        </div>

                        <form method="GET" action="{{ route('properties.index') }}" class="space-y-6">
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">{{ __('Search') }}</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search...') }}" class="w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent text-sm">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">{{ __('Transaction') }}</label>
                                <div class="flex bg-gray-100 rounded-lg p-1">
                                    <label class="flex-1 text-center cursor-pointer">
                                        <input type="radio" name="transaction_type" value="sale" class="sr-only peer" {{ request('transaction_type') == 'sale' ? 'checked' : '' }}>
                                        <span class="block py-2 text-xs font-bold text-gray-500 rounded-md peer-checked:bg-white peer-checked:text-accent peer-checked:shadow-sm transition-all">{{ __('Buy') }}</span>
                                    </label>
                                    <label class="flex-1 text-center cursor-pointer">
                                        <input type="radio" name="transaction_type" value="rent" class="sr-only peer" {{ request('transaction_type') == 'rent' ? 'checked' : '' }}>
                                        <span class="block py-2 text-xs font-bold text-gray-500 rounded-md peer-checked:bg-white peer-checked:text-accent peer-checked:shadow-sm transition-all">{{ __('Rent') }}</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">{{ __('City') }}</label>
                                <select name="city" class="w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent text-sm">
                                    <option value="">{{ __('All') }}</option>
                                    @foreach(['Lisboa','Porto','Cascais','Faro','Braga','Coimbra'] as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">{{ __('Property Type') }}</label>
                                <select name="type" class="w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent text-sm">
                                    <option value="">{{ __('All') }}</option>
                                    @foreach(['apartment','house','villa','land','commercial','office'] as $type)
                                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ __(ucfirst($type)) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">{{ __('Price') }}</label>
                                <div class="flex gap-2">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent text-sm">
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">{{ __('Bedrooms') }}</label>
                                <div class="flex gap-2">
                                    @foreach([1,2,3,4] as $bed)
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="bedrooms" value="{{ $bed }}" class="sr-only peer" {{ request('bedrooms') == $bed ? 'checked' : '' }}>
                                            <div class="py-2 text-center text-xs font-bold border border-gray-200 rounded-lg peer-checked:border-accent peer-checked:bg-accent/5 peer-checked:text-accent hover:border-gray-300 transition-all">
                                                {{ $bed }}+
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-graphite hover:bg-black text-white font-bold py-3 rounded-lg transition-colors shadow-lg">
                                {{ __('Apply Filters') }}
                            </button>
                        </form>
                    </div>
                </aside>

                <div class="flex-1">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <h2 class="text-2xl font-heading font-bold text-graphite">{{ __('Properties') }}</h2>
                            <p class="text-gray-500 text-sm mt-1">{{ $properties->total() }} {{ __('results') }}</p>
                        </div>
                    </div>

                    @if($properties->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($properties as $property)
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group h-full flex flex-col">
                                    <div class="relative aspect-[4/3] overflow-hidden">
                                        <a href="{{ route('properties.show', $property) }}">
                                            @if($property->cover_image)
                                                <img src="{{ Storage::url($property->cover_image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            @elseif($property->images && count($property->images) > 0)
                                                <img src="{{ Storage::url($property->images[0]) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-400">{{ __('No Image') }}</span>
                                                </div>
                                            @endif
                                        </a>
                                        
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-white/90 backdrop-blur-sm text-graphite px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide shadow-sm">
                                                {{ __(ucfirst($property->type)) }}
                                            </span>
                                        </div>

                                        @if($property->is_exclusive)
                                            <div class="absolute top-4 right-4">
                                                <span class="bg-accent text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide shadow-sm">
                                                    {{ __('Off-Market') }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-5 flex flex-col flex-1">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="text-lg font-bold text-graphite line-clamp-1 group-hover:text-accent transition-colors">
                                                <a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a>
                                            </h3>
                                        </div>
                                        <p class="text-gray-500 text-xs mb-4 flex items-center gap-1 uppercase tracking-wide">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $property->city }}
                                        </p>

                                        <div class="flex items-center gap-4 text-sm text-gray-600 mb-6 mt-auto">
                                            <span class="flex items-center gap-1"><span class="font-bold">{{ $property->bedrooms }}</span> {{ __('Bedrooms') }}</span>
                                            <span class="flex items-center gap-1"><span class="font-bold">{{ $property->area }}</span> m²</span>
                                        </div>

                                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                            <span class="text-xl font-bold text-graphite">{{ $property->formatted_price }}</span>
                                            <a href="{{ route('properties.show', $property) }}" class="text-accent font-medium hover:underline text-sm">{{ __('View') }} &rarr;</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-12">
                            {{ $properties->links() }}
                        </div>
                    @else
                        <div class="text-center py-20 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-graphite mb-1">{{ __('No properties found') }}</h3>
                            <p class="text-gray-500 text-sm">{{ __('Try adjusting your filters.') }}</p>
                            <a href="{{ route('properties.index') }}" class="inline-block mt-4 text-accent font-bold hover:underline">{{ __('Clear Filters') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    @include('components.footer')
</x-public-layout>