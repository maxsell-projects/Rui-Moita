@php
$services = [
    [
        'title' => __('Investment Consulting'),
        'description' => __('Strategic guidance to identify and acquire premium properties that align with your investment goals and risk profile.'),
        'icon' => 'building',
    ],
    [
        'title' => __('Relocation Services'),
        'description' => __('Comprehensive support for families and professionals relocating to Portugal, from visas to lifestyle integration.'),
        'icon' => 'user-check',
    ],
    [
        'title' => __('International Portfolio'),
        'description' => __('Access to exclusive off-market opportunities across Portugal\'s most desirable locations and emerging markets.'),
        'icon' => 'globe',
    ],
    [
        'title' => __('Family Office Solutions'),
        'description' => __('Bespoke wealth management and real estate services for high-net-worth individuals and family offices.'),
        'icon' => 'briefcase',
    ],
];
@endphp

<section id="services" class="py-24 bg-background">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-up">
            <div class="inline-block px-4 py-1 bg-accent/10 rounded-full mb-6">
                <span class="text-accent text-sm font-medium">{{ __('Our Services') }}</span>
            </div>
            <h2 class="font-heading text-4xl md:text-5xl font-bold mb-6 text-foreground">
                {{ __('Boutique Consulting Excellence') }}
            </h2>
            <p class="text-lg text-muted-foreground">
                {{ __('Personalized service, complete transparency, and exclusive access to premium opportunities') }}
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            @foreach($services as $index => $service)
            <div class="group p-8 rounded-lg border border-border hover:border-accent/50 bg-card transition-all duration-300 hover:shadow-xl animate-fade-up"
                 style="animation-delay: {{ $index * 0.1 }}s">
                <div class="w-14 h-14 rounded-lg bg-accent/10 flex items-center justify-center mb-6 group-hover:bg-accent/20 transition-colors">
                    @if($service['icon'] === 'building')
                        <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    @elseif($service['icon'] === 'user-check')
                        <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    @elseif($service['icon'] === 'globe')
                        <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </div>
                <h3 class="font-heading text-xl font-bold mb-3 text-foreground">
                    {{ $service['title'] }}
                </h3>
                <p class="text-muted-foreground leading-relaxed">{{ $service['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>