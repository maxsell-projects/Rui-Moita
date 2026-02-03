@extends('layouts.app')

@section('title', __('Recrutamento') . ' | Porthouse Private Office')

@section('content')

{{-- 1. HERO SECTION: DARK (Para o Header ficar legível) --}}
<section class="relative pt-52 pb-24 bg-brand-secondary text-white overflow-hidden">
    {{-- Background Sutil --}}
    <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2301&auto=format&fit=crop')] bg-cover bg-center"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-brand-secondary via-brand-secondary/90 to-brand-secondary"></div>

    <div class="container mx-auto px-6 relative z-10 text-center" data-aos="fade-up">
        <p class="text-brand-accent uppercase tracking-[0.3em] text-[10px] font-bold mb-6 flex justify-center items-center gap-3">
            <span class="w-6 h-[1px] bg-brand-accent"></span>
            {{ __('Carreiras') }}
            <span class="w-6 h-[1px] bg-brand-accent"></span>
        </p>
        <h1 class="font-serif text-4xl md:text-6xl mb-6 leading-tight">
            {{ __('Defina o padrão') }} <span class="italic text-brand-accent">{{ __('da excelência.') }}</span>
        </h1>
        <p class="text-lg text-white/70 font-light max-w-2xl mx-auto leading-relaxed">
            {{ __('Na Intellectus, gerimos património e construímos legados. Se procura alta performance e uma marca de prestígio, o seu lugar é aqui.') }}
        </p>
    </div>
</section>

{{-- 2. SECÇÃO BRANCA (Conteúdo + Formulário) --}}
<section class="py-24 bg-white text-brand-text relative">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            {{-- LADO ESQUERDO: Benefícios --}}
            <div class="lg:col-span-4 space-y-12" data-aos="fade-right">
                <div>
                    <h3 class="font-serif text-2xl text-brand-secondary mb-6">{{ __('Porquê a Intellectus?') }}</h3>
                    <p class="text-gray-500 font-light text-sm leading-relaxed text-justify">
                        {{ __('Oferecemos um ecossistema desenhado para consultores que já não se contentam com o mediano. Aqui, terá o suporte necessário para fechar negócios complexos.') }}
                    </p>
                </div>

                <div class="space-y-8">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-brand-surface flex items-center justify-center text-brand-secondary flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm uppercase tracking-wide text-brand-secondary mb-1">{{ __('Comissionamento Premium') }}</h4>
                            <p class="text-xs text-gray-500">{{ __('Estrutura de remuneração acima da média de mercado.') }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-brand-surface flex items-center justify-center text-brand-secondary flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm uppercase tracking-wide text-brand-secondary mb-1">{{ __('Formação de Elite') }}</h4>
                            <p class="text-xs text-gray-500">{{ __('Mentoria contínua em Luxury Real Estate e Negociação.') }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-brand-surface flex items-center justify-center text-brand-secondary flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm uppercase tracking-wide text-brand-secondary mb-1">{{ __('Network Exclusivo') }}</h4>
                            <p class="text-xs text-gray-500">{{ __('Acesso direto a uma carteira de investidores privada.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- LADO DIREITO: Formulário Branco Clean --}}
            <div class="lg:col-span-8 bg-gray-50 border border-gray-100 p-8 md:p-12 rounded-sm shadow-sm" data-aos="fade-left">
                <div class="mb-10">
                    <h2 class="font-serif text-2xl text-brand-secondary mb-2">{{ __('Candidatura Espontânea') }}</h2>
                    <p class="text-xs text-gray-400 uppercase tracking-widest">{{ __('Confidencialidade Absoluta') }}</p>
                </div>

                @if(session('success'))
                    <div class="p-4 mb-8 bg-green-50 border-l-2 border-green-500 text-green-700 text-xs uppercase tracking-wide">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 mb-8 bg-red-50 border-l-2 border-red-500 text-red-700 text-xs uppercase tracking-wide">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('recruitment.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    {{-- Grid Nome / Telefone --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">{{ __('Nome Completo') }}</label>
                            <input type="text" name="name" class="w-full bg-white border border-gray-200 focus:border-brand-primary focus:ring-0 px-4 py-3 text-brand-secondary text-sm transition-colors placeholder-gray-300" placeholder="{{ __('Seu nome') }}" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">{{ __('Telefone') }}</label>
                            <input type="text" name="phone" class="w-full bg-white border border-gray-200 focus:border-brand-primary focus:ring-0 px-4 py-3 text-brand-secondary text-sm transition-colors placeholder-gray-300" placeholder="+351..." required>
                        </div>
                    </div>

                    {{-- Grid Email / LinkedIn --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">{{ __('Email') }}</label>
                            <input type="email" name="email" class="w-full bg-white border border-gray-200 focus:border-brand-primary focus:ring-0 px-4 py-3 text-brand-secondary text-sm transition-colors placeholder-gray-300" placeholder="email@exemplo.com" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">{{ __('LinkedIn') }} <span class="text-gray-300 normal-case ml-1">({{ __('Opcional') }})</span></label>
                            <input type="url" name="linkedin" class="w-full bg-white border border-gray-200 focus:border-brand-primary focus:ring-0 px-4 py-3 text-brand-secondary text-sm transition-colors placeholder-gray-300" placeholder="https://linkedin.com/in/...">
                        </div>
                    </div>

                    {{-- Mensagem --}}
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">{{ __('Mensagem de Apresentação') }}</label>
                        <textarea name="message" rows="3" class="w-full bg-white border border-gray-200 focus:border-brand-primary focus:ring-0 px-4 py-3 text-brand-secondary text-sm transition-colors resize-none placeholder-gray-300" placeholder="{{ __('Fale-nos um pouco sobre si...') }}"></textarea>
                    </div>

                    {{-- Upload CV --}}
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">{{ __('Anexar CV (PDF)') }}</label>
                        <label class="flex items-center justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-200 border-dashed rounded-sm appearance-none cursor-pointer hover:border-brand-primary hover:bg-gray-50 group">
                            <div class="flex flex-col items-center space-y-2">
                                <svg class="w-8 h-8 text-gray-300 group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                <span class="text-xs text-gray-500 group-hover:text-brand-secondary"><span class="font-bold underline">{{ __('Clique para carregar') }}</span> {{ __('ou arraste o ficheiro') }}</span>
                                <span class="text-[10px] text-gray-400" id="fileNamePlaceholder">PDF até 5MB</span>
                            </div>
                            <input type="file" name="cv" accept=".pdf" class="hidden" onchange="document.getElementById('fileNamePlaceholder').innerText = this.files[0].name; document.getElementById('fileNamePlaceholder').classList.add('text-brand-primary', 'font-bold');">
                        </label>
                    </div>

                    {{-- Botão Submit --}}
                    <div class="pt-4 text-right">
                        <button type="submit" class="inline-block w-full md:w-auto px-10 py-4 bg-brand-primary text-white uppercase text-xs font-bold tracking-[0.2em] hover:bg-brand-secondary transition-all shadow-lg transform hover:-translate-y-1">
                            {{ __('Enviar Candidatura') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection