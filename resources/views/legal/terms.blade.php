@extends('layouts.app')

@section('title', __('Termos e Condições | Intellectus'))

@section('content')

{{-- HEADER MINIMALISTA (Azul Profundo) --}}
<div class="bg-brand-secondary text-white pt-32 pb-12 text-center">
    <div class="container mx-auto px-6">
        <p class="text-brand-accent font-mono text-xs uppercase tracking-[0.4em] mb-4">{{ __('Legal & Compliance') }}</p>
        <h1 class="text-4xl md:text-5xl font-serif">{{ __('Termos e Condições') }}</h1>
    </div>
</div>

<div class="py-20 bg-brand-background relative">
    
    {{-- Marca d'água decorativa --}}
    <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

    <div class="container mx-auto px-6 max-w-4xl relative z-10">
        <div class="bg-white p-12 md:p-20 shadow-2xl border-t-8 border-brand-accent relative overflow-hidden">
            
            {{-- Selo Decorativo --}}
            <div class="absolute top-10 right-10 opacity-5">
                <span class="font-serif text-9xl text-brand-secondary">§</span>
            </div>

            <div class="prose prose-lg max-w-none text-gray-600 font-light leading-relaxed">
                
                <p class="text-lg">
                    {!! __('Bem-vindo ao ecossistema digital da <strong>Intellectus | Rui Moita Private Office</strong>. Ao aceder e utilizar este website, estabelece um compromisso de honra em respeitar os seguintes termos e condições de uso.') !!}
                </p>

                <div class="my-12 w-24 h-[1px] bg-brand-accent"></div>

                <div class="space-y-10">
                    {{-- 1. Identificação --}}
                    <div>
                        <h3 class="text-xl font-serif text-brand-secondary mb-3 flex items-center gap-3">
                            <span class="text-brand-accent text-sm">01.</span> {{ __('Identificação e Propriedade') }}
                        </h3>
                        <p class="text-sm text-justify">
                            {!! __('Este domínio e os seus conteúdos são propriedade exclusiva de <strong>Rui Moita</strong> e da marca <strong>Intellectus</strong>, consultoria imobiliária independente especializada no segmento *High Net Worth*, com escritório profissional situado na Avenida da Liberdade, Lisboa.') !!}
                        </p>
                    </div>

                    {{-- 2. Propriedade Intelectual --}}
                    <div>
                        <h3 class="text-xl font-serif text-brand-secondary mb-3 flex items-center gap-3">
                            <span class="text-brand-accent text-sm">02.</span> {{ __('Propriedade Intelectual') }}
                        </h3>
                        <p class="text-sm text-justify">
                            {{ __('A curadoria visual, textos, vídeos e identidade gráfica ("Intellectus Private Office") estão protegidos por direitos de autor e propriedade intelectual. A reprodução, cópia ou uso de qualquer material sem autorização expressa e por escrito é estritamente proibida e passível de procedimento judicial.') }}
                        </p>
                    </div>

                    {{-- 3. Informação --}}
                    <div>
                        <h3 class="text-xl font-serif text-brand-secondary mb-3 flex items-center gap-3">
                            <span class="text-brand-accent text-sm">03.</span> {{ __('Rigor da Informação') }}
                        </h3>
                        <p class="text-sm text-justify">
                            {{ __('As informações sobre os ativos imobiliários apresentados (áreas, valores, plantas) são baseadas em dados recolhidos com rigor, mas possuem caráter meramente informativo e não constituem proposta contratual vinculativa. Reservamo-nos o direito de alterar, sem aviso prévio, as condições de comercialização de qualquer imóvel.') }}
                        </p>
                    </div>

                    {{-- 4. Responsabilidade --}}
                    <div>
                        <h3 class="text-xl font-serif text-brand-secondary mb-3 flex items-center gap-3">
                            <span class="text-brand-accent text-sm">04.</span> {{ __('Limitação de Responsabilidade') }}
                        </h3>
                        <p class="text-sm text-justify">
                            {{ __('Embora empreguemos as melhores práticas de cibersegurança, não nos responsabilizamos por danos decorrentes de falhas de sistema, vírus informáticos ou indisponibilidade temporária do website.') }}
                        </p>
                    </div>

                    {{-- 5. Lei --}}
                    <div>
                        <h3 class="text-xl font-serif text-brand-secondary mb-3 flex items-center gap-3">
                            <span class="text-brand-accent text-sm">05.</span> {{ __('Jurisdição') }}
                        </h3>
                        <p class="text-sm text-justify">
                            {{ __('Estes termos regem-se pela lei portuguesa. Para dirimir qualquer litígio emergente da utilização deste serviço, é competente o foro da comarca de Lisboa, com expressa renúncia a qualquer outro.') }}
                        </p>
                    </div>
                </div>

                <div class="mt-16 pt-8 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400 uppercase tracking-widest font-mono">
                    <span>{{ __('Versão 2.1') }}</span>
                    <span>{{ __('Atualizado: Janeiro 2026') }}</span>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection