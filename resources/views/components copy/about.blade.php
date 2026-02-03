<section id="about" class="py-24 bg-background">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
            <div class="animate-fade-up">
                <div class="inline-block px-4 py-1 bg-accent/10 rounded-full mb-6">
                    <span class="text-accent text-sm font-medium">{{ __('About Crow Global') }}</span>
                </div>
                <h2 class="font-heading text-4xl md:text-5xl font-bold mb-6 text-foreground">
                    {{ __('Excellence in Real Estate') }}
                </h2>
                <p class="text-lg text-muted-foreground mb-6 leading-relaxed">
                    {{ __('Crow Global Investments connects international capital to exceptional properties across Portugal, delivering a boutique consulting experience with complete transparency.') }}
                </p>
                <p class="text-lg text-muted-foreground mb-8 leading-relaxed">
                    {{ __('Our deep market knowledge, combined with exclusive access to off-market opportunities, ensures our clients discover investments that truly match their vision and financial goals.') }}
                </p>

                <div class="grid grid-cols-3 gap-6 mb-8">
                    <div class="text-center">
                        <div class="text-3xl font-heading font-bold text-accent mb-2">15+</div>
                        <div class="text-sm text-muted-foreground">{{ __('Years Experience') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-heading font-bold text-accent mb-2">€500M+</div>
                        <div class="text-sm text-muted-foreground">{{ __('Assets Managed') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-heading font-bold text-accent mb-2">30+</div>
                        <div class="text-sm text-muted-foreground">{{ __('Countries Served') }}</div>
                    </div>
                </div>
            </div>

            <div class="animate-fade-up">
                <img
                    src="{{ asset('images/about-team.jpg') }}"
                    alt="Crow Global Team"
                    class="rounded-lg shadow-2xl w-full h-[600px] object-cover"
                />
            </div>
        </div>
    </div>
</section>