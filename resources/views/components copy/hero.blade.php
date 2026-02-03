<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img
            src="{{ asset('images/hero-luxury.jpg') }}"
            alt="Luxury Portuguese Architecture"
            class="w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-gradient-to-b from-graphite/80 via-graphite/60 to-graphite/80"></div>
    </div>

    <div class="container relative z-10 mx-auto px-4 text-center">
        <div class="max-w-4xl mx-auto animate-fade-up">
            
            <div class="w-32 h-32 sm:w-40 sm:h-40 mx-auto bg-white/10 backdrop-blur-sm rounded-full p-3 border-4 border-accent shadow-2xl overflow-hidden mb-6">
                <img 
                    src="{{ asset('images/client-logo.png') }}" 
                    alt="Logo do Cliente" 
                    class="w-full h-full object-contain rounded-full"
                >
            </div>

            <h1 class="font-heading text-5xl md:text-7xl font-bold text-white mb-6 tracking-tight">
                {{ __('Where Vision Meets Value') }}
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-2xl mx-auto">
                {{ __('Premium Real Estate Investments in Portugal') }}
            </p>
            <p class="text-lg text-white/80 mb-12 max-w-xl mx-auto">
                {{ __('Discover exceptional opportunities across Portugal\'s most exclusive markets') }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a
                    href="#municipalities"
                    class="inline-flex items-center justify-center px-8 py-3 text-base font-medium rounded-md text-white bg-accent hover:bg-accent/90 transition-colors"
                >
                    {{ __('Explore Municipalities') }}
                </a>
                <a
                    href="#contact"
                    class="inline-flex items-center justify-center px-8 py-3 text-base font-medium rounded-md border border-white/30 text-white hover:bg-white/10 backdrop-blur-sm transition-colors"
                >
                    {{ __('Join Off Market Club') }}
                </a>
            </div>
        </div>

        {{-- Seta Scroll Down Corrigida --}}
        <a
            href="#about"
            class="absolute bottom-12 left-1/2 -translate-x-1/2 text-white/60 hover:text-accent transition-colors animate-bounce"
            aria-label="Scroll to content"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </a>
    </div>
</section>