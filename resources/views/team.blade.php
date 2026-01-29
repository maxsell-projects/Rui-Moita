@extends('layouts.app')

@section('title', __('A Nossa Equipa'))

@section('content')

{{-- Estado Global do Modal (Alpine.js) --}}
<div x-data="{ activeModal: null }" @keydown.escape.window="activeModal = null">

    {{-- 1. HERO SECTION (Ajustada: Azul Primary + Espaçamento Correcto) --}}
    <section class="relative pt-52 pb-32 bg-brand-primary text-white overflow-hidden">
        {{-- Padrão de Fundo Sutil --}}
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        
        {{-- Gradiente Decorativo --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-transparent pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <p class="text-brand-sand uppercase tracking-[0.3em] text-[10px] font-bold mb-6 animate-fade-in-up flex justify-center items-center gap-3">
                <span class="w-6 h-[1px] bg-brand-sand"></span>
                {{ __('Intellectus Private Office') }}
                <span class="w-6 h-[1px] bg-brand-sand"></span>
            </p>
            <h1 class="font-serif text-3xl md:text-5xl mb-6 leading-tight animate-fade-in-up delay-100">
                {{ __('Os nossos especialistas.') }}
            </h1>
            
            <p class="font-light text-base text-white/80 max-w-2xl mx-auto animate-fade-in-up delay-200 leading-relaxed">
                {{ __('Rigor, discrição e resultados. Conheça a equipa que protege o seu património.') }}
            </p>
        </div>
    </section>

    {{-- 2. GRELHA DE CONSULTORES (Cartões Pequenos) --}}
    <section class="py-20 bg-brand-background min-h-[500px]">
        <div class="container mx-auto px-6">
            {{-- Grid ajustado para cartões menores (2 col mobile, 4 col desktop) --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                
                @forelse($consultants as $consultant)
                    <div class="group cursor-pointer" @click="activeModal = {{ $consultant->id }}" data-aos="fade-up">
                        {{-- Foto Compacta --}}
                        <div class="aspect-square relative overflow-hidden rounded-sm bg-gray-100 mb-4 shadow-sm group-hover:shadow-xl transition-all duration-500">
                            <img src="{{ $consultant->photo_url }}" 
                                 alt="{{ $consultant->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 filter grayscale group-hover:grayscale-0">
                            
                            {{-- Overlay "Ver Perfil" --}}
                            <div class="absolute inset-0 bg-brand-secondary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <span class="text-white text-[10px] uppercase font-bold tracking-widest border border-white/30 px-3 py-2 hover:bg-white hover:text-brand-secondary transition-colors">
                                    {{ __('Ver Perfil') }}
                                </span>
                            </div>
                        </div>

                        {{-- Info Minimalista --}}
                        <div class="text-center">
                            <h3 class="font-serif text-lg text-brand-secondary group-hover:text-brand-primary transition-colors">{{ $consultant->name }}</h3>
                            <p class="text-[10px] uppercase tracking-widest text-brand-sand font-bold mt-1">{{ $consultant->role }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-gray-400 font-serif italic">{{ __('A equipa está a ser atualizada.') }}</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

    {{-- 3. MODAIS (Escondidos até clicar) --}}
    @foreach($consultants as $consultant)
        <div x-show="activeModal === {{ $consultant->id }}" 
             x-cloak
             class="fixed inset-0 z-[100] flex items-center justify-center px-4"
             style="display: none;">
            
            {{-- Backdrop Escuro --}}
            <div class="absolute inset-0 bg-brand-secondary/95 backdrop-blur-sm transition-opacity" 
                 x-show="activeModal === {{ $consultant->id }}"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="activeModal = null"></div>

            {{-- O Cartão do Modal --}}
            <div class="relative bg-white w-full max-w-4xl rounded-sm shadow-2xl overflow-hidden flex flex-col md:flex-row max-h-[90vh]"
                 x-show="activeModal === {{ $consultant->id }}"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4">

                {{-- Botão Fechar --}}
                <button @click="activeModal = null" class="absolute top-4 right-4 z-10 w-8 h-8 flex items-center justify-center bg-white/10 hover:bg-gray-100 rounded-full text-gray-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                {{-- Coluna Esquerda: Foto Grande --}}
                <div class="w-full md:w-5/12 h-64 md:h-auto relative bg-gray-100">
                    <img src="{{ $consultant->photo_url }}" class="absolute inset-0 w-full h-full object-cover grayscale">
                </div>

                {{-- Coluna Direita: Detalhes --}}
                <div class="w-full md:w-7/12 p-8 md:p-12 overflow-y-auto custom-scrollbar bg-white">
                    
                    {{-- Cabeçalho do Consultor --}}
                    <div class="mb-8 border-b border-gray-100 pb-6">
                        <span class="text-brand-sand uppercase tracking-[0.2em] text-[10px] font-bold mb-2 block">{{ $consultant->role }}</span>
                        <h2 class="font-serif text-3xl md:text-4xl text-brand-secondary mb-1">{{ $consultant->name }}</h2>
                    </div>

                    {{-- Bio --}}
                    @if($consultant->bio)
                        <div class="prose prose-sm text-gray-500 font-light leading-relaxed mb-8 text-justify">
                            {!! nl2br(e($consultant->bio)) !!}
                        </div>
                    @else
                        <p class="text-gray-400 italic mb-8">{{ __('Sem biografia disponível.') }}</p>
                    @endif

                    {{-- Contactos --}}
                    <div class="space-y-4">
                        <h4 class="font-serif text-lg text-brand-secondary mb-4">{{ __('Contactos Diretos') }}</h4>
                        
                        @if($consultant->phone)
                            <div class="flex items-center gap-4 group">
                                <div class="w-10 h-10 bg-brand-background rounded-full flex items-center justify-center text-brand-secondary group-hover:bg-brand-secondary group-hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">{{ __('Telefone') }}</p>
                                    <a href="tel:{{ $consultant->phone }}" class="font-serif text-lg text-brand-secondary hover:text-brand-primary transition-colors">{{ $consultant->phone }}</a>
                                </div>
                            </div>
                        @endif

                        @if($consultant->email)
                            <div class="flex items-center gap-4 group">
                                <div class="w-10 h-10 bg-brand-background rounded-full flex items-center justify-center text-brand-secondary group-hover:bg-brand-secondary group-hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">{{ __('Email') }}</p>
                                    <a href="mailto:{{ $consultant->email }}" class="font-serif text-lg text-brand-secondary hover:text-brand-primary transition-colors">{{ $consultant->email }}</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Redes Sociais --}}
                    <div class="mt-8 pt-8 border-t border-gray-100 flex gap-4">
                        @if($consultant->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $consultant->whatsapp) }}" target="_blank" class="px-6 py-3 bg-[#25D366] text-white rounded-sm text-xs font-bold uppercase tracking-widest hover:bg-[#128C7E] transition-colors flex items-center gap-2">
                                <span class="text-base">W</span> WhatsApp
                            </a>
                        @endif
                        
                        @if($consultant->linkedin)
                            <a href="{{ $consultant->linkedin }}" target="_blank" class="w-10 h-10 border border-gray-200 flex items-center justify-center text-gray-400 hover:text-brand-primary hover:border-brand-primary transition-colors">
                                <span class="font-bold">in</span>
                            </a>
                        @endif
                        @if($consultant->instagram)
                            <a href="{{ $consultant->instagram }}" target="_blank" class="w-10 h-10 border border-gray-200 flex items-center justify-center text-gray-400 hover:text-brand-primary hover:border-brand-primary transition-colors">
                                <span class="font-bold">Ig</span>
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endforeach

</div>

{{-- CTA Recruitment --}}
<section class="py-20 bg-white border-t border-gray-100">
    <div class="container mx-auto px-6 text-center">
        <h2 class="font-serif text-3xl text-brand-secondary mb-4">{{ __('Junte-se a nós') }}</h2>
        <p class="text-gray-500 font-light mb-8 max-w-xl mx-auto">
            {{ __('Procuramos profissionais alinhados com a nossa cultura de excelência.') }}
        </p>
        <a href="{{ route('recruitment') }}" class="inline-block px-10 py-4 bg-brand-secondary text-white uppercase text-xs font-bold tracking-[0.2em] hover:bg-brand-primary transition-all shadow-lg transform hover:-translate-y-1">
            {{ __('Trabalhe Connosco') }}
        </a>
    </div>
</section>

@endsection