{{-- FILE: resources/views/about.blade.php --}}

@extends('layouts.app')

@section('title', __('A Visão | Intellectus Private Office'))

@section('content')

{{-- 1. HERO: INSTITUCIONAL & SOBRIEDADE --}}
{{-- Alteração: Mudança de bg-brand-secondary para bg-[#0A0F14] (Dark Slate) para contraste com o Header --}}
{{-- Alteração: Adicionado pt-32 lg:pt-40 para compensar o Header Fixo --}}
<section class="relative min-h-[60vh] flex items-center justify-center bg-[#0A0F14] text-white overflow-hidden pt-32 lg:pt-40 pb-20">
    
    {{-- Textura de fundo sutil --}}
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    {{-- Elemento Decorativo (Gradiente) --}}
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-brand-secondary/20 to-transparent pointer-events-none"></div>

    <div class="container mx-auto px-6 relative z-10 text-center" data-aos="fade-up">
        <p class="text-brand-sand font-mono text-xs uppercase tracking-[0.4em] mb-8 flex items-center justify-center gap-4">
            <span class="w-8 h-[1px] bg-brand-primary/50"></span>
            {{ __('Private Office') }}
            <span class="w-8 h-[1px] bg-brand-primary/50"></span>
        </p>
        
        {{-- Alteração: "Rui Moita" -> "Intellectus" --}}
        <h1 class="text-6xl md:text-9xl font-serif leading-none mb-8 text-white tracking-tight">
            Intellectus
        </h1>
        
        {{-- Linha vertical --}}
        <div class="w-px h-24 bg-brand-primary/30 mx-auto"></div>
    </div>
</section>

{{-- 2. MANIFESTO (Novo Texto) --}}
<section class="py-32 bg-brand-background">
    <div class="container mx-auto px-6 max-w-4xl text-center" data-aos="fade-up">
        <h2 class="text-2xl md:text-4xl font-serif text-brand-secondary leading-tight mb-12">
            "{{ __('Porque os bens da vida têm de estar seguros.') }}"
            <br>
            <span class="italic text-brand-primary text-3xl md:text-5xl mt-2 block">{{ __('E a segurança vem do conhecimento.') }}</span>
        </h2>
        
        <div class="prose prose-lg text-brand-text/80 font-light text-lg leading-relaxed text-justify md:text-center mx-auto">
            <p>
                {{ __('A') }} <strong>Intellectus</strong> {{ __('existe para tornar o processo imobiliário seguro, claro e humano. Trabalhamos com rigor, transparência e conhecimento real para proteger decisões de vida, do primeiro contacto ao pós-venda.') }}
            </p>
        </div>
    </div>
</section>

{{-- 3. BIO DO FUNDADOR & EXPERTISE --}}
<section class="py-24 bg-white border-y border-brand-sand/20">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            
            {{-- Foto Editorial --}}
            <div class="lg:col-span-5 relative" data-aos="fade-right">
                <div class="relative overflow-hidden aspect-[3/4] group shadow-2xl border border-gray-100">
                    <img src="{{ asset('img/1.jpeg') }}" 
                         alt="Rui Moita - Fundador Intellectus" 
                         class="w-full h-full object-cover grayscale transition-all duration-1000 group-hover:grayscale-0 group-hover:scale-105">
                    
                    {{-- Badge Minimalista --}}
                    <div class="absolute bottom-0 left-0 bg-brand-secondary text-white p-8 max-w-[85%] border-l-4 border-brand-primary">
                        <p class="font-serif text-3xl italic text-white">{{ __('15+ Anos') }}</p>
                        <p class="text-[10px] uppercase tracking-widest text-brand-sand mt-1">{{ __('De Experiência em Mercado Prime') }}</p>
                    </div>
                </div>
                {{-- Outline Decorativo --}}
                <div class="absolute -z-10 top-6 -right-6 w-full h-full border border-brand-secondary/10"></div>
            </div>

            {{-- Texto Bio (Refatorado para voz da Empresa) --}}
            <div class="lg:col-span-7 space-y-12 pl-0 lg:pl-12">
                <div data-aos="fade-up">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-brand-primary mb-6 flex items-center gap-3">
                        <span class="w-6 h-[1px] bg-brand-primary"></span>
                        {{ __('A Liderança') }}
                    </h3>
                    <h2 class="text-4xl md:text-5xl font-serif text-brand-secondary mb-8 leading-tight">
                        {{ __('Da Banca Privada à') }} <br>{{ __('Gestão de Património.') }}
                    </h2>
                    
                    <div class="prose prose-lg text-gray-500 font-light leading-relaxed space-y-6 text-justify">
                        {{-- Alteração: Texto focado na fundação e não apenas no "Eu" --}}
                        <p>
                            {{ __('Fundada por') }} <strong>Rui Moita</strong>, {{ __('a Intellectus nasce de uma carreira sólida na gestão de ativos, onde a premissa sempre foi clara: os números contam histórias. Essa bagagem analítica permite à nossa equipa olhar para um imóvel não apenas como "espaço", mas como um') }} <strong>{{ __('ativo financeiro vivo') }}</strong>.
                        </p>
                        <p>
                            {{ __('Especializamo-nos na gestão de clientes') }} <em>High Net Worth</em>, {{ __('onde a discrição e a eficiência são pré-requisitos absolutos. O nosso trabalho inicia-se muito antes da visita e termina muito depois da escritura.') }}
                        </p>
                        <p>
                             {{ __('Acompanhamos processos de Vistos Gold, estruturação fiscal e reinstalação de famílias em Portugal, atuando como o ponto de contacto central de confiança.') }}
                        </p>
                    </div>
                </div>

                {{-- Assinatura --}}
                <div data-aos="fade-up" data-aos-delay="200" class="border-t border-gray-100 pt-8">
                    <p class="font-serif italic text-3xl text-brand-secondary">Rui Moita</p>
                    <p class="text-xs text-brand-primary uppercase tracking-widest mt-2">{{ __('Fundador & Senior Partner') }}</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 4. PILARES / VALORES --}}
<section class="py-32 bg-brand-secondary text-white relative overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16 divide-y md:divide-y-0 md:divide-x divide-white/5">
            
            <div class="px-6 py-8 md:py-0 text-center md:text-left group" data-aos="fade-up" data-aos-delay="0">
                <span class="text-brand-primary font-serif text-6xl mb-8 block opacity-80 group-hover:scale-110 transition-transform">01.</span>
                <h4 class="text-xl font-bold uppercase tracking-widest mb-6 text-white">{{ __('Integridade Inegociável') }}</h4>
                <p class="text-brand-sand/60 font-light leading-relaxed text-sm">
                    {{ __('A confiança demora anos a construir. Pautamos a nossa conduta pela transparência absoluta. Se um negócio não for vantajoso para o portfólio do cliente, seremos os primeiros a desaconselhá-lo.') }}
                </p>
            </div>

            <div class="px-6 py-8 md:py-0 text-center md:text-left group" data-aos="fade-up" data-aos-delay="200">
                <span class="text-brand-primary font-serif text-6xl mb-8 block opacity-80 group-hover:scale-110 transition-transform">02.</span>
                <h4 class="text-xl font-bold uppercase tracking-widest mb-6 text-white">{{ __('Inteligência de Mercado') }}</h4>
                <p class="text-brand-sand/60 font-light leading-relaxed text-sm">
                    {{ __('Não vendemos intuição; vendemos dados. As nossas recomendações baseiam-se em análises comparativas,') }} <em>Yields</em> {{ __('reais e projeções fundamentadas.') }}
                </p>
            </div>

            <div class="px-6 py-8 md:py-0 text-center md:text-left group" data-aos="fade-up" data-aos-delay="400">
                <span class="text-brand-primary font-serif text-6xl mb-8 block opacity-80 group-hover:scale-110 transition-transform">03.</span>
                <h4 class="text-xl font-bold uppercase tracking-widest mb-6 text-white">{{ __('Discrição Absoluta') }}</h4>
                <p class="text-brand-sand/60 font-light leading-relaxed text-sm">
                    {{ __('Compreendemos a natureza sensível dos grandes movimentos de capital. Garantimos total sigilo em todas as fases do processo, protegendo a identidade e os interesses dos nossos parceiros.') }}
                </p>
            </div>

        </div>
    </div>
</section>

{{-- 5. CTA --}}
<section class="py-32 bg-white text-center relative overflow-hidden">
    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-2 h-32 bg-brand-secondary"></div>

    <div class="container mx-auto px-6" data-aos="zoom-in">
        <h2 class="text-4xl md:text-6xl font-serif text-brand-secondary mb-8 leading-tight">
            {{ __('Da conversa reservada') }}<br>
            <span class="italic text-brand-primary">{{ __('ao legado definitivo.') }}</span>
        </h2>
        
        <p class="text-gray-500 mb-12 font-light text-lg">{{ __('Vamos discutir o futuro do seu portfólio imobiliário?') }}</p>
        
        <a href="{{ route('contact') }}" class="group relative inline-flex items-center gap-4 px-12 py-5 bg-brand-secondary text-white text-xs font-bold uppercase tracking-[0.2em] overflow-hidden hover:bg-brand-primary hover:text-brand-secondary transition-all duration-500 shadow-xl">
            <span>{{ __('Agendar Reunião') }}</span>
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
</section>

@endsection