@extends('layouts.app')

@section('title', 'Contactar Private Office | Intellectus')

@section('content')

{{-- ESTRUTURA SPLIT-SCREEN (TELA DIVIDIDA) --}}
<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- COLUNA ESQUERDA: INFORMAÇÃO & CONTEXTO (Azul Profundo) --}}
    <div class="lg:w-5/12 bg-brand-secondary text-white relative flex flex-col justify-between p-12 lg:p-20 overflow-hidden">
        
        {{-- Padrão de Fundo --}}
        <div class="absolute inset-0 opacity-5 pointer-events-none" 
             style="background-image: linear-gradient(#C5A059 1px, transparent 1px), linear-gradient(90deg, #C5A059 1px, transparent 1px); background-size: 60px 60px;">
        </div>

        {{-- Cabeçalho da Coluna --}}
        <div class="relative z-10">
            <p class="text-brand-primary font-mono text-xs uppercase tracking-[0.4em] mb-6">
                Intellectus Private Office
            </p>
            <h1 class="font-serif text-5xl lg:text-6xl leading-tight mb-8">
                Conversas que definem <span class="text-brand-primary italic">legados.</span>
            </h1>
            <p class="text-white/60 font-light leading-relaxed max-w-sm">
                A nossa equipa, liderada por <strong>Rui Moita</strong>, assegura um acompanhamento discreto e estratégico para operações imobiliárias de alto volume.
            </p>
        </div>

        {{-- Info de Contacto --}}
        <div class="relative z-10 mt-16 space-y-12">
            
            {{-- Endereço --}}
            <div class="flex gap-6 items-start group">
                <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center text-brand-primary group-hover:bg-brand-primary group-hover:text-brand-secondary transition-all duration-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Sede</h4>
                    <p class="font-serif text-xl">Avenida da Liberdade, 100</p>
                    <p class="text-sm text-white/60">1250-144 Lisboa, Portugal</p>
                </div>
            </div>

            {{-- Contactos Diretos --}}
            <div class="flex gap-6 items-start group">
                <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center text-brand-primary group-hover:bg-brand-primary group-hover:text-brand-secondary transition-all duration-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Atendimento</h4>
                    <a href="tel:+351910000000" class="block font-serif text-xl hover:text-brand-primary transition-colors">+351 910 000 000</a>
                    <a href="mailto:contact@intellectus.pt" class="block text-sm text-white/60 hover:text-white mt-1">contact@intellectus.pt</a>
                </div>
            </div>

        </div>

        {{-- Nota de Rodapé da Coluna --}}
        <div class="relative z-10 mt-16 lg:mt-auto pt-8 border-t border-white/10">
            <p class="text-[10px] text-white/40 uppercase tracking-widest">
                &copy; {{ date('Y') }} Intellectus. Rui Moita Private Office.
            </p>
        </div>
    </div>

    {{-- COLUNA DIREITA: FORMULÁRIO (Off-white) --}}
    <div class="lg:w-7/12 bg-white flex items-center justify-center p-8 lg:p-20">
        <div class="w-full max-w-xl">
            
            <div class="mb-12">
                <h3 class="font-serif text-3xl text-brand-secondary mb-4">Formulário de Contacto</h3>
                <p class="text-gray-500 font-light text-sm">
                    Preencha os campos abaixo. A nossa equipa entrará em contacto num prazo máximo de 24 horas úteis.
                </p>
                
                @if(session('success'))
                    <div class="mt-6 p-4 bg-green-50 text-green-800 text-sm border-l-2 border-green-600">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <form action="{{ route('contact.send') }}" method="POST" class="space-y-8">
                @csrf
                
                {{-- Nome --}}
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 group-focus-within:text-brand-secondary transition-colors">Nome Completo</label>
                    <input type="text" name="name" required 
                           class="w-full border-0 border-b border-gray-200 py-3 text-brand-secondary text-lg focus:ring-0 focus:border-brand-primary bg-transparent placeholder-gray-200 transition-colors"
                           placeholder="Ex: Rui Moita">
                </div>

                {{-- Contactos (Grid) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 group-focus-within:text-brand-secondary transition-colors">Email</label>
                        <input type="email" name="email" required 
                               class="w-full border-0 border-b border-gray-200 py-3 text-brand-secondary focus:ring-0 focus:border-brand-primary bg-transparent placeholder-gray-200 transition-colors"
                               placeholder="nome@empresa.com">
                    </div>
                    <div class="group">
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 group-focus-within:text-brand-secondary transition-colors">Telemóvel</label>
                        <input type="tel" name="phone" required 
                               class="w-full border-0 border-b border-gray-200 py-3 text-brand-secondary focus:ring-0 focus:border-brand-primary bg-transparent placeholder-gray-200 transition-colors"
                               placeholder="+351 ...">
                    </div>
                </div>

                {{-- Contexto (Grid) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2">Assunto</label>
                        <select name="subject" class="w-full border-0 border-b border-gray-200 py-3 text-brand-secondary focus:ring-0 focus:border-brand-primary bg-transparent cursor-pointer">
                            <option value="Comprar">Comprar Imóvel</option>
                            <option value="Vender">Vender Imóvel</option>
                            <option value="Investimento">Investimento</option>
                            <option value="Outro">Outro Assunto</option>
                        </select>
                    </div>
                    <div class="group">
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2">Prazo</label>
                        <select name="timeline" class="w-full border-0 border-b border-gray-200 py-3 text-brand-secondary focus:ring-0 focus:border-brand-primary bg-transparent cursor-pointer">
                            <option value="Imediato">Imediato</option>
                            <option value="3 Meses">Até 3 Meses</option>
                            <option value="6 Meses">Até 6 Meses</option>
                            <option value="Indefinido">Indefinido</option>
                        </select>
                    </div>
                </div>

                {{-- Mensagem --}}
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 group-focus-within:text-brand-secondary transition-colors">Mensagem Privada</label>
                    <textarea name="message" rows="3" required 
                              class="w-full border-0 border-b border-gray-200 py-3 text-brand-secondary focus:ring-0 focus:border-brand-primary bg-transparent resize-none placeholder-gray-200 transition-colors"
                              placeholder="Descreva brevemente o seu objetivo..."></textarea>
                </div>

                {{-- Campos Ocultos (SOP / Backend Compatibility) --}}
                <input type="hidden" name="goal" value="Contacto Direto">
                <input type="hidden" name="sell_to_buy" value="N/A">

                {{-- Checkbox --}}
                <div class="pt-4">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input type="checkbox" name="privacy_check" required 
                               class="mt-1 w-4 h-4 text-brand-primary border-gray-300 rounded focus:ring-brand-primary cursor-pointer">
                        <span class="text-xs text-gray-400 leading-relaxed group-hover:text-gray-500 transition-colors">
                            Li e aceito a <a href="{{ route('terms') }}" class="underline hover:text-brand-secondary">Política de Privacidade</a>. Compreendo que os dados fornecidos serão tratados exclusivamente pela Intellectus para fins de resposta.
                        </span>
                    </label>
                </div>

                {{-- Botão --}}
                <div class="pt-6">
                    <button type="submit" class="w-full bg-brand-secondary text-white py-5 font-bold uppercase tracking-[0.2em] text-xs hover:bg-brand-primary hover:text-brand-secondary transition-all duration-300 shadow-xl">
                        Enviar Pedido de Contacto
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection