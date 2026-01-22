<div x-data="{ 
    showConsent: false, 
    showPrivacyModal: false, 
    
    init() {
        // Sincronizado com a chave usada no layout principal para evitar conflitos
        if (!localStorage.getItem('cookie_consent')) {
            setTimeout(() => this.showConsent = true, 1000);
        }
    },

    acceptCookies() {
        // Define a chave correta para que o banner não reapareça
        localStorage.setItem('cookie_consent', 'true');
        this.showConsent = false;
        this.showPrivacyModal = false;
    }
}">

    {{-- BARRA DE CONSENTIMENTO --}}
    <div x-show="showConsent" 
         x-cloak
         style="display: none;"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         {{-- Aumentado o Z-Index para 100 para garantir clique acima do botão de WhatsApp (z-40) --}}
         class="fixed bottom-0 left-0 w-full z-[100] bg-brand-secondary/95 backdrop-blur-md border-t border-brand-accent/30 p-6 md:p-8 shadow-[0_-10px_40px_rgba(0,0,0,0.4)]">
        
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left flex-1">
                <p class="text-sm text-white/90 leading-relaxed font-light">
                    Na <strong>Intellectus | Rui Moita Private Office</strong>, a privacidade é um ativo fundamental. Utilizamos cookies para garantir a segurança da sua navegação. Ao continuar, aceita a nossa 
                    <button @click="showPrivacyModal = true" class="text-brand-accent hover:text-white underline decoration-brand-accent/50 hover:decoration-white transition-all font-medium">Política de Privacidade & Compliance</button>.
                </p>
            </div>
            <div class="flex gap-4 w-full md:w-auto">
                {{-- No mobile, o botão agora ocupa largura total para facilitar o toque --}}
                <button @click="acceptCookies()" class="w-full md:w-auto px-8 py-4 md:py-3 bg-brand-accent text-brand-secondary text-xs font-bold uppercase tracking-widest hover:bg-white transition-all duration-300 rounded-sm whitespace-nowrap shadow-lg">
                    Aceitar
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL DE POLÍTICA DE PRIVACIDADE --}}
    <div x-show="showPrivacyModal" 
         x-cloak
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-brand-secondary/90 backdrop-blur-sm">
        
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
                    <button @click="showPrivacyModal = false" class="text-gray-400 hover:text-brand-secondary transition-colors p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="flex space-x-8 overflow-x-auto scrollbar-hide border-b border-gray-100">
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
                <div x-show="activeTab === 'privacy'" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                    <p>A <strong>Intellectus Private Office</strong>, com escritório em Lisboa, Portugal, é a entidade responsável pela gestão deste domínio.</p>
                    <p>Estamos empenhados em proteger a privacidade e os dados pessoais dos nossos clientes, em conformidade com o RGPD.</p>
                    <h3 class="text-brand-secondary font-serif font-bold mt-8 mb-2 text-lg">Tratamento de Dados</h3>
                    <p>Os dados recolhidos (nome, email, telefone) destinam-se exclusivamente à gestão de pedidos de consultoria e cumprimento de obrigações legais.</p>
                </div>

                <div x-show="activeTab === 'cookies'" style="display: none;" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                    <h3 class="text-brand-secondary font-serif font-bold mt-0 mb-2 text-lg">Política de Cookies</h3>
                    <p>Utilizamos cookies estritamente necessários para o funcionamento e segurança do site (CSRF, gestão de sessão).</p>
                </div>

                <div x-show="activeTab === 'ral'" style="display: none;" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                    <h3 class="text-brand-secondary font-serif font-bold mt-0 mb-4 text-lg">RAL</h3>
                    <p>Em caso de litígio, o cliente pode recorrer ao CNIACC (www.cniacc.pt).</p>
                </div>
            </div>

            {{-- Footer do Modal --}}
            <div class="bg-gray-50 border-t border-gray-200 p-6 flex justify-end flex-none">
                <button @click="acceptCookies()" class="w-full md:w-auto px-8 py-3 bg-brand-secondary text-white text-[10px] font-bold uppercase tracking-widest hover:bg-brand-primary transition-all duration-300 rounded-sm shadow-lg">
                    Li e Aceito
                </button>
            </div>
        </div>
    </div>
</div>