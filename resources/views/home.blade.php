@extends('layouts.app')

@section('title', 'Intellectus | Gestão Patrimonial e Investimento')

@section('content')

    {{-- 1. HERO: A AUTORIDADE SILENCIOSA --}}
    <section class="relative min-h-screen flex items-center bg-intellectus-primary text-white overflow-hidden pt-20">
        
        {{-- Grid Decorativo (Subtil) --}}
        <div class="absolute inset-0 pointer-events-none opacity-10" 
             style="background-image: linear-gradient(#C5A059 1px, transparent 1px), linear-gradient(90deg, #C5A059 1px, transparent 1px); background-size: 80px 80px;">
        </div>

        <div class="container mx-auto px-6 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 h-full items-center">
            <div class="lg:col-span-8 lg:col-start-2">
                <p class="font-sans text-xs uppercase tracking-[0.4em] text-intellectus-accent mb-6 animate-fade-in-up">
                    Private Office & Strategy
                </p>
                <h1 class="font-serif text-5xl lg:text-7xl leading-[1.1] mb-8 font-light">
                    Inteligência patrimonial <br>
                    <span class="italic text-gray-400">aplicada com rigor.</span>
                </h1>
                <div class="h-px w-24 bg-intellectus-accent mb-8"></div>
                <p class="font-sans text-gray-300 text-lg max-w-xl leading-relaxed font-light">
                    Decisões estruturais exigem método, visão e proteção. 
                    Atuamos na interseção onde a estratégia encontra o patrimônio imobiliário.
                </p>

                <div class="mt-12 flex flex-col md:flex-row gap-6">
                    <a href="#analise-estrategica" class="group relative px-8 py-4 bg-intellectus-accent text-intellectus-base font-sans text-xs font-bold uppercase tracking-widest hover:bg-white transition-colors duration-500">
                        Iniciar Conversa Estratégica
                    </a>
                    <a href="#atuacao" class="group px-8 py-4 border border-white/20 text-white font-sans text-xs font-bold uppercase tracking-widest hover:border-intellectus-accent hover:text-intellectus-accent transition-colors duration-500">
                        Nossa Atuação
                    </a>
                </div>
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-50">
            <span class="text-[10px] uppercase tracking-widest">Scroll</span>
            <div class="w-px h-12 bg-gradient-to-b from-intellectus-accent to-transparent"></div>
        </div>
    </section>

    {{-- 2. POSICIONAMENTO (Editorial) --}}
    <section class="py-24 bg-intellectus-surface text-intellectus-base">
        <div class="container mx-auto px-6 border-l border-intellectus-base/10 ml-6 lg:ml-auto max-w-6xl pl-12">
            <h2 class="font-serif text-3xl lg:text-5xl mb-12">
                Mais do que mediação. <br>
                <span class="text-intellectus-muted">Guardiões de decisões fundamentais.</span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 font-sans text-gray-600 leading-loose font-light">
                <p>
                    A Intellectus não opera no mercado de volume. Operamos no mercado de precisão. 
                    Cada ativo é selecionado cirurgicamente para proteger legado, mitigar riscos e garantir 
                    a longevidade do patrimônio familiar e corporativo.
                </p>
                <p>
                    Acreditamos que o imobiliário de luxo não é sobre metros quadrados, é sobre a 
                    estabilidade do futuro. A nossa conduta é pautada pela discrição absoluta e pela 
                    análise técnica desprovida de emoção comercial.
                </p>
            </div>
        </div>
    </section>

    {{-- 3. PILARES (Grid Minimalista) --}}
    <section class="py-24 bg-white border-t border-gray-100">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                @foreach([
                    'Rigor Técnico' => 'Análise baseada em dados, não em tendências.',
                    'Blindagem' => 'Privacidade absoluta em cada etapa da transação.',
                    'Curadoria' => 'Acesso a ativos off-market e pocket listings.',
                    'Humanização' => 'Um processo desenhado para pessoas, não transações.'
                ] as $title => $desc)
                <div class="p-8 group hover:bg-intellectus-surface transition-colors duration-500">
                    <div class="w-2 h-2 bg-intellectus-accent mb-6 rounded-full group-hover:scale-150 transition-transform"></div>
                    <h3 class="font-serif text-xl mb-3 text-intellectus-primary">{{ $title }}</h3>
                    <p class="font-sans text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. O CONSULTOR (Líder) --}}
    <section class="py-24 bg-intellectus-base text-white relative overflow-hidden">
        <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            {{-- Foto --}}
            <div class="relative order-2 lg:order-1">
                <div class="aspect-[3/4] bg-gray-800 grayscale relative overflow-hidden border border-white/10">
                    <img src="{{ asset('img/1.jpeg') }}" alt="Consultor Senior" class="object-cover w-full h-full hover:scale-105 transition-transform duration-1000 opacity-80 hover:opacity-100">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-intellectus-accent text-intellectus-base p-6 w-48">
                    <p class="font-serif italic text-lg leading-tight">"Onde há patrimônio, deve haver método."</p>
                </div>
            </div>

            <div class="order-1 lg:order-2">
                <h2 class="font-serif text-4xl mb-6">Expertise que protege.</h2>
                <p class="font-sans text-gray-400 mb-8 leading-relaxed font-light">
                    Com mais de uma década de atuação em mercados de alta volatilidade e valorização, 
                    lidero a Intellectus com uma visão clara: oferecer aos nossos clientes a segurança 
                    de que cada decisão é tomada com base em inteligência de mercado sólida.
                </p>
                
                <ul class="space-y-4 font-sans text-sm text-gray-300 mb-12">
                    <li class="flex items-center gap-4"><span class="w-8 h-px bg-intellectus-accent"></span> Especialista em Investimento</li>
                    <li class="flex items-center gap-4"><span class="w-8 h-px bg-intellectus-accent"></span> Consultoria Jurídica Imobiliária</li>
                    <li class="flex items-center gap-4"><span class="w-8 h-px bg-intellectus-accent"></span> Gestão de Portfólio Familiar</li>
                </ul>

                <p class="font-serif text-2xl italic text-intellectus-accent">Marco Moura</p>
            </div>
        </div>
    </section>

    {{-- [NOVA DOBRA 1] EQUIPA / INTELLIGENCE COLLECTIVE --}}
    <section class="py-24 bg-white border-b border-gray-100">
        <div class="container mx-auto px-6 text-center max-w-4xl">
            <span class="text-xs font-bold uppercase tracking-[0.2em] text-intellectus-muted mb-4 block">A Nossa Estrutura</span>
            <h2 class="font-serif text-3xl md:text-4xl text-intellectus-primary mb-8">Intelligence Collective</h2>
            <p class="font-sans text-gray-500 font-light leading-relaxed mb-10">
                A gestão patrimonial de excelência não é um ato solitário. 
                Apoiamos os nossos clientes com uma equipa multidisciplinar que integra especialistas em investimento, 
                direito e finanças, garantindo uma visão 360º sobre cada ativo.
            </p>
            
            <a href="{{ route('team') }}" class="group inline-flex items-center gap-3 px-8 py-4 border border-intellectus-primary text-intellectus-primary font-bold uppercase tracking-widest text-xs hover:bg-intellectus-primary hover:text-white transition-all duration-300">
                Conhecer a Equipa
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>

    {{-- 5. ATUAÇÃO / SOLUÇÕES --}}
    <section id="atuacao" class="py-24 bg-intellectus-surface">
        <div class="container mx-auto px-6">
            <div class="mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-intellectus-muted">Áreas de Foco</span>
                <h2 class="font-serif text-4xl mt-4 text-intellectus-primary">Arquitetura de Soluções</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Card 1 --}}
                <div class="bg-white p-12 hover:shadow-2xl hover:shadow-gray-200/50 transition-all duration-500 border border-gray-100 group">
                    <span class="text-4xl font-serif text-gray-200 group-hover:text-intellectus-accent transition-colors">01.</span>
                    <h3 class="font-serif text-2xl mt-4 mb-4 text-intellectus-primary">Aquisição de Ativos</h3>
                    <p class="text-gray-500 font-light leading-relaxed mb-8">
                        Identificação e negociação de propriedades para habitação ou rendimento, com foco na valorização a longo prazo.
                    </p>
                    <a href="{{ route('portfolio') }}" class="text-xs font-bold uppercase tracking-widest text-intellectus-base border-b border-intellectus-base pb-1">Ver Portfólio</a>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white p-12 hover:shadow-2xl hover:shadow-gray-200/50 transition-all duration-500 border border-gray-100 group">
                    <span class="text-4xl font-serif text-gray-200 group-hover:text-intellectus-accent transition-colors">02.</span>
                    <h3 class="font-serif text-2xl mt-4 mb-4 text-intellectus-primary">Desinvestimento Estratégico</h3>
                    <p class="text-gray-500 font-light leading-relaxed mb-8">
                        Maximização do valor de venda através de marketing direcionado e acesso a uma base de compradores qualificada.
                    </p>
                    <a href="#analise-estrategica" class="text-xs font-bold uppercase tracking-widest text-intellectus-base border-b border-intellectus-base pb-1">Avaliar Imóvel</a>
                </div>
            </div>
        </div>
    </section>

    {{-- [NOVA DOBRA 2] RECRUTAMENTO --}}
    <section class="py-0 bg-intellectus-base text-white">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="relative h-96 lg:h-auto min-h-[400px] overflow-hidden group">
                {{-- Imagem de Fundo (Ex: Arquitetura ou Escritório) --}}
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2301&auto=format&fit=crop" 
                     class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-1000">
                <div class="absolute inset-0 bg-gradient-to-r from-intellectus-base/90 to-transparent"></div>
            </div>
            
            <div class="p-16 lg:p-24 flex flex-col justify-center">
                <span class="text-intellectus-accent uppercase tracking-widest text-xs font-bold mb-4">Carreiras & Expansão</span>
                <h2 class="font-serif text-3xl lg:text-4xl mb-6 leading-tight">Junte-se ao Private Office.</h2>
                <p class="text-gray-400 font-light leading-relaxed mb-8">
                    Se procura elevar o nível da sua carreira no imobiliário de luxo, com acesso a formação de elite, 
                    ferramentas exclusivas e comissões acima da média, o seu lugar é na Intellectus.
                </p>
                <div>
                    <a href="{{ route('recruitment') }}" class="inline-block px-8 py-4 bg-intellectus-accent text-intellectus-base font-bold uppercase tracking-widest text-xs hover:bg-white transition-all duration-300 shadow-lg">
                        Candidatura Espontânea
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. RESPALDO (Testemunhos) --}}
    <section class="py-24 bg-white border-b border-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="font-serif text-3xl text-center mb-16 text-intellectus-primary">A confiança de quem decide.</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center px-4">
                    <div class="text-intellectus-accent text-4xl font-serif mb-4">“</div>
                    <p class="font-serif text-lg text-gray-600 italic mb-6">
                        A clareza técnica e a ausência de pressão comercial foram determinantes. Encontramos não apenas uma casa, mas um ativo seguro.
                    </p>
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Dr. Ricardo S., Investidor</p>
                </div>

                <div class="text-center px-4 border-l border-r border-gray-100">
                    <div class="text-intellectus-accent text-4xl font-serif mb-4">“</div>
                    <p class="font-serif text-lg text-gray-600 italic mb-6">
                        O processo de due diligence foi impecável. Senti-me blindado juridicamente do início ao fim da operação.
                    </p>
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Ana P., CEO</p>
                </div>

                <div class="text-center px-4">
                    <div class="text-intellectus-accent text-4xl font-serif mb-4">“</div>
                    <p class="font-serif text-lg text-gray-600 italic mb-6">
                        Eficiência e discrição. O acesso a propriedades que não estavam no mercado público fez toda a diferença.
                    </p>
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Família M., International Buyers</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 7. FORMULÁRIO / CTA FINAL --}}
    <section id="analise-estrategica" class="py-24 bg-intellectus-primary relative">
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                
                <div class="lg:col-span-4 text-white">
                    <h2 class="font-serif text-4xl mb-6">Solicitar Análise Estratégica</h2>
                    <p class="text-gray-400 font-light mb-8 text-justify">
                        Para garantir a excelência do nosso atendimento, trabalhamos com um número limitado de clientes. 
                        Preencha o formulário para agendar uma consultoria confidencial.
                    </p>
                    <div class="h-px w-12 bg-intellectus-accent mb-8"></div>
                    
                    <div class="text-sm text-gray-500 space-y-2 font-mono">
                        <p>PRIVATE OFFICE</p>
                        <p class="text-gray-300">Lisboa • Porto • Algarve</p>
                        <p class="text-gray-300">+351 910 000 000</p>
                        <p class="text-gray-300">consultoria@intellectus.pt</p>
                    </div>
                </div>

                <div class="lg:col-span-8 bg-white p-10 lg:p-16 shadow-2xl rounded-sm">
                    <form action="{{ route('contact.send') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @csrf
                        
                        <div class="col-span-2 md:col-span-1 group">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 group-focus-within:text-intellectus-primary transition-colors">Nome Completo *</label>
                            <input type="text" name="name" required class="w-full border-b border-gray-200 py-3 text-gray-800 focus:outline-none focus:border-intellectus-accent transition-colors bg-transparent placeholder-gray-300 font-serif" placeholder="Seu nome">
                        </div>

                        <div class="col-span-2 md:col-span-1 group">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 group-focus-within:text-intellectus-primary transition-colors">Email Corporativo/Pessoal *</label>
                            <input type="email" name="email" required class="w-full border-b border-gray-200 py-3 text-gray-800 focus:outline-none focus:border-intellectus-accent transition-colors bg-transparent placeholder-gray-300 font-serif" placeholder="email@exemplo.com">
                        </div>

                        <div class="col-span-2 md:col-span-1 group">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 group-focus-within:text-intellectus-primary transition-colors">Telefone *</label>
                            <input type="tel" name="phone" required class="w-full border-b border-gray-200 py-3 text-gray-800 focus:outline-none focus:border-intellectus-accent transition-colors bg-transparent placeholder-gray-300 font-serif" placeholder="+351 ...">
                        </div>

                        <div class="col-span-2 md:col-span-1 group">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 group-focus-within:text-intellectus-primary transition-colors">Localização de Interesse *</label>
                            <input type="text" name="location" required class="w-full border-b border-gray-200 py-3 text-gray-800 focus:outline-none focus:border-intellectus-accent transition-colors bg-transparent placeholder-gray-300 font-serif" placeholder="Ex: Cascais, Estoril...">
                        </div>

                        <div class="col-span-2">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-4">Objetivo da Operação *</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="objective" value="Comprar" class="peer sr-only" required>
                                    <span class="px-6 py-3 border border-gray-200 text-xs uppercase tracking-widest text-gray-500 peer-checked:bg-intellectus-primary peer-checked:text-white peer-checked:border-intellectus-primary transition-all">Comprar</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="objective" value="Vender" class="peer sr-only">
                                    <span class="px-6 py-3 border border-gray-200 text-xs uppercase tracking-widest text-gray-500 peer-checked:bg-intellectus-primary peer-checked:text-white peer-checked:border-intellectus-primary transition-all">Vender</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="objective" value="Investir" class="peer sr-only">
                                    <span class="px-6 py-3 border border-gray-200 text-xs uppercase tracking-widest text-gray-500 peer-checked:bg-intellectus-primary peer-checked:text-white peer-checked:border-intellectus-primary transition-all">Investir</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="objective" value="Arrendar" class="peer sr-only">
                                    <span class="px-6 py-3 border border-gray-200 text-xs uppercase tracking-widest text-gray-500 peer-checked:bg-intellectus-primary peer-checked:text-white peer-checked:border-intellectus-primary transition-all">Arrendar</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1 group">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2">Tipologia</label>
                            <select name="typology" class="w-full border-b border-gray-200 py-3 text-gray-800 bg-transparent focus:outline-none focus:border-intellectus-accent font-serif">
                                <option value="">Selecione...</option>
                                <option value="T1/T2">Apartamento (T1/T2)</option>
                                <option value="T3+">Apartamento Familiar (T3+)</option>
                                <option value="Villa">Villa / Moradia</option>
                                <option value="Terreno">Terreno / Desenvolvimento</option>
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1 group">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2">Prazo Pretendido</label>
                            <select name="timeline" class="w-full border-b border-gray-200 py-3 text-gray-800 bg-transparent focus:outline-none focus:border-intellectus-accent font-serif">
                                <option value="imediato">0 meses (Imediato)</option>
                                <option value="3m">Até 3 meses</option>
                                <option value="6m">Até 6 meses</option>
                                <option value="futuro">Mais de 6 meses</option>
                            </select>
                        </div>

                        <div class="col-span-2">
                            <p class="block text-[10px] uppercase tracking-widest text-gray-400 mb-3">Necessita vender para comprar?</p>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="sell_to_buy" value="Sim" class="text-intellectus-accent focus:ring-intellectus-accent">
                                    <span class="text-sm text-gray-600">Sim, é uma troca</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="sell_to_buy" value="Nao" checked class="text-intellectus-accent focus:ring-intellectus-accent">
                                    <span class="text-sm text-gray-600">Não</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-span-2 mt-4 pt-4 border-t border-gray-50">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="privacy_policy" required class="mt-1 text-intellectus-accent border-gray-300 rounded focus:ring-intellectus-accent">
                                <span class="text-xs text-gray-400 leading-relaxed">
                                    Li e aceito a <a href="{{ route('terms') }}" class="underline hover:text-intellectus-primary">Política de Privacidade</a>. 
                                    Autorizo o tratamento dos meus dados para efeitos de resposta a este pedido de análise.
                                </span>
                            </label>
                        </div>

                        <div class="col-span-2 mt-2">
                            <button type="submit" class="w-full bg-intellectus-base text-white py-5 font-bold uppercase tracking-widest text-xs hover:bg-intellectus-primary transition-all duration-300 shadow-lg hover:shadow-xl">
                                Enviar Pedido de Análise
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection