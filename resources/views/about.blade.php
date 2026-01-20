@extends('layouts.app')

@section('title', 'A Visão | Intellectus Private Office')

@section('content')

{{-- 1. HERO: SÓBRIO & INSTITUCIONAL --}}
<section class="relative h-[60vh] min-h-[500px] flex items-center justify-center bg-brand-secondary text-white overflow-hidden">
    {{-- Textura de fundo sutil --}}
    <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    {{-- Elemento Decorativo (Gradiente Azul) --}}
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-black/30 to-transparent pointer-events-none"></div>

    <div class="container mx-auto px-6 relative z-10 text-center" data-aos="fade-up">
        <p class="text-brand-sand font-mono text-xs uppercase tracking-[0.4em] mb-8 flex items-center justify-center gap-4">
            <span class="w-8 h-[1px] bg-brand-primary/50"></span> {{-- Dourado Sutil --}}
            Consultoria Privada
            <span class="w-8 h-[1px] bg-brand-primary/50"></span>
        </p>
        <h1 class="text-6xl md:text-9xl font-serif leading-none mb-8 text-white tracking-tight">
            Rui Moita
        </h1>
        {{-- Linha vertical --}}
        <div class="w-px h-24 bg-brand-primary/30 mx-auto"></div>
    </div>
</section>

{{-- 2. MANIFESTO --}}
<section class="py-32 bg-brand-background">
    <div class="container mx-auto px-6 max-w-5xl text-center" data-aos="fade-up">
        <h2 class="text-3xl md:text-5xl font-serif text-brand-secondary leading-tight mb-12">
            "A verdadeira arte da mediação imobiliária não reside na transação, mas na <span class="italic text-brand-secondary border-b border-brand-primary pb-1">perpetuação do património.</span>"
        </h2>
        
        <p class="text-brand-text/80 font-light text-lg leading-relaxed text-justify md:text-center max-w-3xl mx-auto">
            Num mundo movido pela velocidade, escolho o <strong>rigor</strong>. O meu compromisso transcende o fecho de negócios; foco-me em desenhar estratégias que perdurem. Acredito que cada ativo imobiliário deve servir um propósito maior: a segurança do seu investimento e o legado da sua família.
        </p>
    </div>
</section>

{{-- 3. BIO & EXPERTISE --}}
<section class="py-24 bg-white border-y border-brand-sand/20">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            
            {{-- Foto Editorial --}}
            <div class="lg:col-span-5 relative" data-aos="fade-right">
                <div class="relative overflow-hidden aspect-[3/4] group shadow-2xl border border-gray-100">
                    {{-- FOTO RUI MOITA --}}
                    <img src="{{ asset('img/1.jpeg') }}" 
                         alt="Rui Moita - Intellectus" 
                         class="w-full h-full object-cover grayscale transition-all duration-1000 group-hover:grayscale-0 group-hover:scale-105">
                    
                    {{-- Badge Minimalista --}}
                    <div class="absolute bottom-0 left-0 bg-brand-secondary text-white p-8 max-w-[85%] border-l-4 border-brand-primary">
                        <p class="font-serif text-3xl italic text-white">15+ Anos</p>
                        <p class="text-[10px] uppercase tracking-widest text-brand-sand mt-1">De Experiência em Mercado Prime</p>
                    </div>
                </div>
                {{-- Outline Decorativo --}}
                <div class="absolute -z-10 top-6 -right-6 w-full h-full border border-brand-secondary/10"></div>
            </div>

            {{-- Texto Bio --}}
            <div class="lg:col-span-7 space-y-12 pl-0 lg:pl-12">
                <div data-aos="fade-up">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-brand-primary mb-6 flex items-center gap-3">
                        <span class="w-6 h-[1px] bg-brand-primary"></span>
                        O Percurso
                    </h3>
                    <h2 class="text-4xl md:text-5xl font-serif text-brand-secondary mb-8 leading-tight">
                        Da Banca Privada à <br>Consultoria Exclusiva.
                    </h2>
                    
                    <div class="prose prose-lg text-gray-500 font-light leading-relaxed space-y-6 text-justify">
                        <p>
                            O meu nome é <strong>Rui Moita</strong>. Antes de fundar a <strong>Intellectus</strong>, construí uma carreira sólida na gestão de ativos, onde aprendi que os números contam histórias. Essa bagagem analítica permite-me hoje olhar para um imóvel não apenas como "espaço", mas como um <strong>ativo financeiro vivo</strong>.
                        </p>
                        <p>
                            Especializei-me na gestão de clientes <em>High Net Worth</em>, onde a discrição e a eficiência não são diferenciais, são pré-requisitos absolutos. O meu trabalho inicia-se muito antes da visita e termina muito depois da escritura.
                        </p>
                        <p>
                             Acompanho processos de Vistos Gold, estruturação fiscal e reinstalação de famílias em Portugal, atuando como o seu único ponto de contacto de confiança.
                        </p>
                    </div>
                </div>

                {{-- Assinatura --}}
                <div data-aos="fade-up" data-aos-delay="200" class="border-t border-gray-100 pt-8">
                    <p class="font-serif italic text-3xl text-brand-secondary">Rui Moita</p>
                    <p class="text-xs text-brand-primary uppercase tracking-widest mt-2">Fundador & Senior Partner</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 4. PILARES / VALORES (Fundo Azul Profundo) --}}
<section class="py-32 bg-brand-secondary text-white relative overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16 divide-y md:divide-y-0 md:divide-x divide-white/5">
            
            <div class="px-6 py-8 md:py-0 text-center md:text-left group" data-aos="fade-up" data-aos-delay="0">
                <span class="text-brand-primary font-serif text-6xl mb-8 block opacity-80 group-hover:scale-110 transition-transform">01.</span>
                <h4 class="text-xl font-bold uppercase tracking-widest mb-6 text-white">Integridade Inegociável</h4>
                <p class="text-brand-sand/60 font-light leading-relaxed text-sm">
                    A confiança demora anos a construir e segundos a perder. Pauto a minha conduta pela transparência absoluta. Se um negócio não for vantajoso para o seu portfólio, serei o primeiro a desaconselhá-lo.
                </p>
            </div>

            <div class="px-6 py-8 md:py-0 text-center md:text-left group" data-aos="fade-up" data-aos-delay="200">
                <span class="text-brand-primary font-serif text-6xl mb-8 block opacity-80 group-hover:scale-110 transition-transform">02.</span>
                <h4 class="text-xl font-bold uppercase tracking-widest mb-6 text-white">Inteligência de Mercado</h4>
                <p class="text-brand-sand/60 font-light leading-relaxed text-sm">
                    Não vendo intuição; vendo dados. As minhas recomendações baseiam-se em análises comparativas de mercado, <em>Yields</em> reais e projeções fundamentadas.
                </p>
            </div>

            <div class="px-6 py-8 md:py-0 text-center md:text-left group" data-aos="fade-up" data-aos-delay="400">
                <span class="text-brand-primary font-serif text-6xl mb-8 block opacity-80 group-hover:scale-110 transition-transform">03.</span>
                <h4 class="text-xl font-bold uppercase tracking-widest mb-6 text-white">Discrição Absoluta</h4>
                <p class="text-brand-sand/60 font-light leading-relaxed text-sm">
                    Compreendo a natureza sensível dos grandes movimentos de capital. Garanto total sigilo em todas as fases do processo, protegendo a sua identidade e os seus interesses.
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
            Da conversa reservada<br>
            <span class="italic text-brand-primary">ao legado definitivo.</span>
        </h2>
        
        <p class="text-gray-500 mb-12 font-light text-lg">Vamos discutir o futuro do seu portfólio imobiliário?</p>
        
        <a href="{{ route('contact') }}" class="group relative inline-flex items-center gap-4 px-12 py-5 bg-brand-secondary text-white text-xs font-bold uppercase tracking-[0.2em] overflow-hidden hover:bg-brand-primary hover:text-brand-secondary transition-all duration-500 shadow-xl">
            <span>Agendar Reunião</span>
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
</section>

@endsection