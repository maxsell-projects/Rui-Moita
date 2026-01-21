@extends('layouts.app')

@section('title', 'Recrutamento')

@section('content')
<div class="flex flex-col lg:flex-row min-h-screen">
    
    {{-- Lado Esquerdo: Imagem / Info --}}
    <div class="lg:w-1/2 bg-brand-secondary text-white relative flex flex-col justify-center px-8 py-20 lg:p-24 overflow-hidden">
        {{-- Background Image Overlay --}}
        <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2301&auto=format&fit=crop')] bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-brand-secondary to-transparent"></div>

        <div class="relative z-10 max-w-xl">
            <p class="text-brand-accent uppercase tracking-[0.3em] text-xs font-bold mb-6">Carreiras</p>
            <h1 class="font-serif text-5xl lg:text-6xl mb-8 leading-tight">
                Defina o padrão da excelência.
            </h1>
            <p class="text-lg text-white/80 font-light leading-relaxed mb-10">
                Na Intellectus, não vendemos apenas imóveis; gerimos património e construímos legados. Se procura um ambiente de alta performance, suporte tecnológico de ponta e uma marca de prestígio, o seu lugar é aqui.
            </p>
            
            <ul class="space-y-4 font-light text-white/70">
                <li class="flex items-center gap-4">
                    <span class="w-2 h-2 bg-brand-accent rounded-full"></span>
                    Comissionamento acima da média de mercado.
                </li>
                <li class="flex items-center gap-4">
                    <span class="w-2 h-2 bg-brand-accent rounded-full"></span>
                    Formação contínua em Luxury Real Estate.
                </li>
                <li class="flex items-center gap-4">
                    <span class="w-2 h-2 bg-brand-accent rounded-full"></span>
                    Acesso a carteira de clientes exclusiva.
                </li>
            </ul>
        </div>
    </div>

    {{-- Lado Direito: Formulário --}}
    <div class="lg:w-1/2 bg-white flex flex-col justify-center px-8 py-20 lg:p-24">
        <div class="max-w-lg mx-auto w-full">
            <h2 class="font-serif text-3xl text-brand-secondary mb-2">Candidatura Espontânea</h2>
            <p class="text-sm text-gray-400 mb-10">Preencha o formulário abaixo. A confidencialidade é total.</p>

            @if(session('success'))
                <div class="p-4 mb-8 bg-green-50 border-l-2 border-green-500 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-8 bg-red-50 border-l-2 border-red-500 text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('recruitment.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Nome Completo</label>
                    <input type="text" name="name" class="w-full border-b border-gray-200 focus:border-brand-secondary focus:ring-0 px-0 py-3 text-brand-secondary font-medium transition-colors placeholder-transparent" placeholder="Nome" required>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Email</label>
                        <input type="email" name="email" class="w-full border-b border-gray-200 focus:border-brand-secondary focus:ring-0 px-0 py-3 text-brand-secondary transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Telefone</label>
                        <input type="text" name="phone" class="w-full border-b border-gray-200 focus:border-brand-secondary focus:ring-0 px-0 py-3 text-brand-secondary transition-colors" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Perfil LinkedIn (Opcional)</label>
                    <input type="url" name="linkedin" class="w-full border-b border-gray-200 focus:border-brand-secondary focus:ring-0 px-0 py-3 text-brand-secondary transition-colors">
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Mensagem de Apresentação</label>
                    <textarea name="message" rows="3" class="w-full border-b border-gray-200 focus:border-brand-secondary focus:ring-0 px-0 py-3 text-brand-secondary transition-colors resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-4 tracking-wider">Anexar CV (PDF)</label>
                    <label class="flex items-center gap-4 cursor-pointer group">
                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 group-hover:bg-brand-secondary group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        </div>
                        <span class="text-sm text-gray-500 group-hover:text-brand-secondary transition-colors">Clique para carregar ficheiro</span>
                        <input type="file" name="cv" accept=".pdf" class="hidden" onchange="this.previousElementSibling.innerText = this.files[0].name">
                    </label>
                </div>

                <div class="pt-8">
                    <button type="submit" class="w-full bg-brand-secondary text-white py-5 uppercase text-[10px] font-bold tracking-[0.2em] hover:bg-brand-accent hover:text-brand-secondary transition-all shadow-xl">
                        Enviar Candidatura
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection