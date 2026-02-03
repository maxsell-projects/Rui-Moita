@php
$municipalities = [
    [
        'name' => 'Lisboa',
        'description' => __('Capital sophistication meets Atlantic charm'),
        'image' => 'lisboa.jpg',
    ],
    [
        'name' => 'Porto',
        'description' => __('Historic grandeur along the Douro River'),
        'image' => 'porto.jpg',
    ],
    [
        'name' => 'Coimbra',
        'description' => __('Academic heritage and cultural richness'),
        'image' => 'coimbra.jpg',
    ],
    [
        'name' => 'Braga',
        'description' => __('Ancient beauty with modern vitality'),
        'image' => 'braga.jpg',
    ],
    [
        'name' => 'Faro',
        'description' => __('Algarve luxury and coastal elegance'),
        'image' => 'faro.jpg',
    ],
    [
        'name' => 'Leiria',
        'description' => __('Medieval charm in central Portugal'),
        'image' => 'leiria.jpg',
    ],
];
@endphp

<section id="municipalities" class="py-24 bg-secondary/30">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-up">
            <div class="inline-block px-4 py-1 bg-accent/10 rounded-full mb-6">
                <span class="text-accent text-sm font-medium">{{ __('Top Destinations') }}</span>
            </div>
            <h2 class="font-heading text-4xl md:text-5xl font-bold mb-6 text-foreground">
                {{ __('Most Sought-After Municipalities') }}
            </h2>
            <p class="text-lg text-muted-foreground">
                {{ __('Explore Portugal\'s most valued regions for investment and lifestyle') }}
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
            @foreach($municipalities as $index => $municipality)
            <a href="{{ route('properties.index', ['city' => $municipality['name']]) }}" 
               class="group relative overflow-hidden rounded-lg cursor-pointer animate-fade-up"
               style="animation-delay: {{ $index * 0.1 }}s">
                <div class="aspect-[4/3] relative">
                    <img
                        src="{{ asset('images/' . $municipality['image']) }}"
                        alt="{{ $municipality['name'] }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-graphite via-graphite/40 to-transparent"></div>

                    <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                        <h3 class="font-heading text-2xl font-bold mb-2">
                            {{ $municipality['name'] }}
                        </h3>
                        <p class="text-white/80 text-sm mb-4">{{ $municipality['description'] }}</p>
                        <div class="flex items-center gap-2 text-accent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-sm font-medium">{{ __('View Properties') }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>