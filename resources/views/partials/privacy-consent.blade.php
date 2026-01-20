<div x-data="{ 
    showConsent: false, 
    showPrivacyModal: false, 
    
    init() {
        // Verifica se já aceitou cookies
        if (!localStorage.getItem('cookies_accepted')) {
            setTimeout(() => this.showConsent = true, 1000);
        }
    },

    acceptCookies() {
        localStorage.setItem('cookies_accepted', 'true');
        this.showConsent = false;
        this.showPrivacyModal = false;
    }
}">

    {{-- BARRA DE CONSENTIMENTO (FIXA NO RODAPÉ) --}}
    <div x-show="showConsent" 
         style="display: none;"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         class="fixed bottom-0 left-0 w-full z-[60] bg-brand-secondary/95 backdrop-blur-md border-t border-brand-accent/30 p-6 md:p-8 shadow-[0_-10px_40px_rgba(0,0,0,0.4)]">
        
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left flex-1">
                <p class="text-sm text-white/90 leading-relaxed font-light">
                    Na <strong>Intellectus | Rui Moita Private Office</strong>, a privacidade é um ativo fundamental. Utilizamos cookies para garantir a segurança da sua navegação. Ao continuar, aceita a nossa 
                    <button @click="showPrivacyModal = true" class="text-brand-accent hover:text-white underline decoration-brand-accent/50 hover:decoration-white transition-all font-medium">Política de Privacidade & Compliance</button>.
                </p>
            </div>
            <div class="flex gap-4">
                <button @click="acceptCookies()" class="px-8 py-3 bg-brand-accent text-brand-secondary text-xs font-bold uppercase tracking-widest hover:bg-white transition-all duration-300 rounded-sm whitespace-nowrap shadow-lg">
                    Aceitar
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL DE POLÍTICA DE PRIVACIDADE --}}
    <div x-show="showPrivacyModal" 
         style="display: none;"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-brand-secondary/90 backdrop-blur-sm">
        
        <div @click.outside="showPrivacyModal = false" 
             class="bg-white w-full max-w-5xl max-h-[85vh] flex flex-col rounded-sm shadow-2xl relative overflow-hidden border-t-8 border-brand-secondary font-sans"
             x-data="{ activeTab: 'privacy' }">
            
            {{-- Header do Modal --}}
            <div class="bg-gray-50 border-b border-gray-200 px-8 pt-8 pb-0 flex-none">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-serif text-brand-secondary">Legal & Compliance</h2>
                        <p class="text-xs text-brand-primary uppercase tracking-widest mt-1">Rui Moita Private Office</p>
                    </div>
                    <button @click="showPrivacyModal = false" class="text-gray-400 hover:text-brand-secondary transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="flex space-x-8 overflow-x-auto scrollbar-hide">
                    <button @click="activeTab = 'privacy'" 
                            :class="activeTab === 'privacy' ? 'border-brand-secondary text-brand-secondary' : 'border-transparent text-gray-400 hover:text-gray-600'"
                            class="pb-4 border-b-2 text-[10px] font-bold uppercase tracking-widest transition-colors duration-300 whitespace-nowrap">
                        Política de Privacidade
                    </button>
                    <button @click="activeTab = 'cookies'" 
                            :class="activeTab === 'cookies' ? 'border-brand-secondary text-brand-secondary' : 'border-transparent text-gray-400 hover:text-gray-600'"
                            class="pb-4 border-b-2 text-[10px] font-bold uppercase tracking-widest transition-colors duration-300 whitespace-nowrap">
                        Política de Cookies
                    </button>
                    <button @click="activeTab = 'ral'" 
                            :class="activeTab === 'ral' ? 'border-brand-secondary text-brand-secondary' : 'border-transparent text-gray-400 hover:text-gray-600'"
                            class="pb-4 border-b-2 text-[10px] font-bold uppercase tracking-widest transition-colors duration-300 whitespace-nowrap">
                        Resolução de Litígios (RAL)
                    </button>
                </div>
            </div>

            {{-- Conteúdo (Scrollable) --}}
            <div class="flex-1 overflow-y-auto p-8 md:p-12 bg-white scrollbar-thin scrollbar-thumb-gray-200">
                
                {{-- TAB: PRIVACIDADE --}}
                <div x-show="activeTab === 'privacy'" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                    <p>A <strong>Intellectus Private Office</strong>, com escritório na <strong>Avenida da Liberdade, Lisboa, Portugal</strong>, é a entidade responsável pela gestão deste domínio.</p>
                    <p>ESTAMOS EMPENHADOS EM PROTEGER A PRIVACIDADE E OS DADOS PESSOAIS DOS NOSSOS CLIENTES E INVESTIDORES, EM ESTRITA CONFORMIDADE COM O RGPD.</p>
                    
                    <h3 class="text-brand-secondary font-serif font-bold mt-8 mb-2 text-lg">1. ÂMBITO DE APLICAÇÃO</h3>
                    <p>Esta Política de Privacidade explica como recolhemos e tratamos os dados pessoais necessários para o fornecimento de serviços de consultoria imobiliária de luxo e gestão de ativos.</p>
                    
                    <h3 class="text-brand-secondary font-serif font-bold mt-8 mb-2 text-lg">2. TRATAMENTO DE DADOS</h3>
                    <p>Os dados pessoais recolhidos (nome, email, telefone, preferências de investimento) destinam-se exclusivamente a:</p>
                    <ul class="list-disc pl-5 space-y-1 marker:text-brand-accent">
                        <li>Gestão de pedidos de consultoria e agendamento de reuniões privadas;</li>
                        <li>Diligências pré-contratuais e contratuais no âmbito da mediação imobiliária;</li>
                        <li>Cumprimento de obrigações legais (ex: identificação de beneficiários efetivos - Lei 83/2017);</li>
                        <li>Comunicação de oportunidades de investimento (apenas com consentimento explícito).</li>
                    </ul>

                    <h3 class="text-brand-secondary font-serif font-bold mt-8 mb-2 text-lg">3. SEGURANÇA E PARTILHA</h3>
                    <p>Implementamos protocolos de segurança robustos para proteger a sua informação. Não comercializamos os seus dados. A partilha com terceiros (advogados, notários, bancos) ocorre apenas quando estritamente necessária para a concretização dos negócios imobiliários e sempre sob dever de sigilo.</p>

                    <h3 class="text-brand-secondary font-serif font-bold mt-8 mb-2 text-lg">4. DIREITOS</h3>
                    <p>Pode exercer os seus direitos de acesso, retificação, eliminação ou oposição ao tratamento, contactando diretamente o nosso Encarregado de Proteção de Dados através de: <strong>compliance@intellectus.pt</strong>.</p>
                </div>

                {{-- TAB: COOKIES --}}
                <div x-show="activeTab === 'cookies'" style="display: none;" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                    <h3 class="text-brand-secondary font-serif font-bold mt-0 mb-2 text-lg">Política de Cookies</h3>
                    <p>Utilizamos cookies para otimizar a sua experiência de navegação e garantir a segurança da plataforma.</p>

                    <h4 class="text-brand-secondary font-bold mt-6 mb-2 text-sm uppercase tracking-wide">Categorias de Cookies</h4>
                    <ul class="list-disc pl-5 space-y-2 marker:text-brand-accent">
                        <li><strong>Estritamente Necessários:</strong> Essenciais para o funcionamento do site (ex: gestão de sessão, segurança CSRF). Não podem ser desligados.</li>
                        <li><strong>Analíticos:</strong> Recolhem dados anónimos sobre o tráfego (ex: páginas mais visitadas) para nos ajudar a melhorar o serviço.</li>
                        <li><strong>Funcionais:</strong> Recordam as suas preferências (ex: idioma, moeda).</li>
                    </ul>

                    <p class="mt-6">Pode gerir as suas preferências de cookies diretamente nas definições do seu navegador.</p>
                </div>

                {{-- TAB: RAL --}}
                <div x-show="activeTab === 'ral'" style="display: none;" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                    <h3 class="text-brand-secondary font-serif font-bold mt-0 mb-4 text-lg">Resolução Alternativa de Litígios (RAL)</h3>
                    
                    <p>Nos termos da Lei n.º 144/2015, de 8 de setembro, informamos que em caso de litígio de consumo, o cliente pode recorrer a uma Entidade de Resolução Alternativa de Litígios de Consumo.</p>
                    
                    <div class="bg-gray-50 border border-gray-200 p-6 rounded-sm mt-6">
                        <p class="font-bold text-brand-secondary mb-1">CNIACC - Centro Nacional de Informação e Arbitragem de Conflitos de Consumo</p>
                        <p class="text-xs text-gray-500 mb-4">Competência genérica</p>
                        
                        <a href="https://www.cniacc.pt" target="_blank" class="flex items-center gap-2 text-brand-primary hover:text-brand-secondary transition-colors font-bold text-xs uppercase tracking-wide">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            www.cniacc.pt
                        </a>
                    </div>
                    
                    <p class="text-xs mt-6 text-gray-400">Para mais informações, consulte o Portal do Consumidor: <a href="https://www.consumidor.gov.pt" target="_blank" class="hover:text-brand-primary underline">www.consumidor.gov.pt</a>.</p>
                </div>

            </div>

            {{-- Footer do Modal --}}
            <div class="bg-gray-50 border-t border-gray-200 p-6 flex justify-end flex-none">
                <button @click="acceptCookies()" class="px-8 py-3 bg-brand-secondary text-white text-[10px] font-bold uppercase tracking-widest hover:bg-brand-primary transition-all duration-300 rounded-sm shadow-lg">
                    Li e Aceito
                </button>
            </div>
        </div>
    </div>
</div>