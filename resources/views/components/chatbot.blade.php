@php
    // 1. Detecta o idioma do site (definido pelo middleware/sessão)
    $locale = app()->getLocale();
    
    // 2. Define a frase de boas-vindas baseada no idioma
    $greeting = match($locale) {
        'en' => "Hello! I am Crow Global AI. I can help you buy, sell, or access the Off-Market. How can I help?",
        'fr' => "Bonjour! Je suis l'IA de Crow Global. Je peux vous aider à acheter, vendre ou accéder au Off-Market. Comment puis-je vous aider?",
        default => "Olá! Sou a IA da Crow Global. Posso ajudar a encontrar imóveis, vender o seu ou falar sobre o mercado exclusivo. Como posso ajudar?",
    };

    // 3. Define o placeholder do input
    $placeholder = match($locale) {
        'en' => "Ask me anything...",
        'fr' => "Posez votre question...",
        default => "Pergunte sobre imóveis...",
    };
@endphp

<div x-data="chatbot()" x-init="initBot()" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
    
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="mb-4 w-[350px] md:w-[400px] h-[500px] bg-white rounded-2xl shadow-2xl border border-gray-100 flex flex-col overflow-hidden font-sans">
        
        <div class="bg-gray-900 p-4 text-white flex justify-between items-center shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                <div>
                    <h3 class="font-bold text-sm">Crow AI Assistant</h3>
                    <p class="text-xs text-gray-400">Online &bull; {{ strtoupper($locale) }}</p>
                </div>
            </div>
            <button @click="open = false" class="hover:text-gray-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto bg-gray-50 space-y-4 scroll-smooth">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.role === 'user' 
                        ? 'bg-gray-800 text-white rounded-br-none' 
                        : 'bg-white border border-gray-200 text-gray-800 rounded-bl-none shadow-sm'"
                        class="max-w-[85%] rounded-2xl px-4 py-2.5 text-sm leading-relaxed relative group">
                        
                        <p x-html="msg.content"></p>
                        
                        <template x-if="msg.data && msg.data.length > 0">
                            <div class="mt-3 space-y-2">
                                <template x-for="prop in msg.data">
                                    <a :href="prop.link" target="_blank" class="block bg-gray-50 hover:bg-gray-100 border rounded-lg p-2 flex gap-3 transition">
                                        <img :src="prop.image" class="w-16 h-16 object-cover rounded-md">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-gray-900 truncate" x-text="prop.title"></p>
                                            <p class="text-xs text-blue-600 font-semibold" x-text="prop.price"></p>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
            
            <div x-show="isLoading" class="flex justify-start">
                <div class="bg-gray-200 rounded-2xl rounded-bl-none px-4 py-3 flex gap-1">
                    <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce delay-75"></div>
                    <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce delay-150"></div>
                </div>
            </div>
        </div>

        <div class="p-3 bg-white border-t border-gray-100">
            <div class="flex items-center gap-2 bg-gray-100 rounded-full px-2 py-2 border border-gray-200 focus-within:border-gray-400 transition">
                
                <button @click="toggleRecording()" 
                    :class="isRecording ? 'bg-red-500 text-white animate-pulse shadow-red-300' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200'"
                    class="p-2 rounded-full transition-all duration-200 shadow-sm flex-shrink-0">
                    <svg x-show="!isRecording" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    <div x-show="isRecording" class="w-5 h-5 flex items-center justify-center">
                        <div class="w-3 h-3 bg-white rounded-sm"></div> 
                    </div>
                </button>

                <input type="text" x-model="userInput" @keydown.enter="sendMessage()" 
                    :placeholder="isRecording ? 'Escutando...' : '{{ $placeholder }}'" 
                    :disabled="isRecording || isLoading"
                    class="flex-1 bg-transparent border-none focus:ring-0 text-sm text-gray-700 placeholder-gray-400">

                <button @click="sendMessage()" :disabled="!userInput.trim() || isLoading" 
                    class="p-2 bg-gray-900 text-white rounded-full hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
            <p class="text-[10px] text-center text-gray-400 mt-2">Powered by Crow Global AI</p>
        </div>
    </div>

    <button @click="open = !open" 
        class="bg-gray-900 hover:bg-gray-800 text-white p-4 rounded-full shadow-2xl transition-all hover:scale-110 flex items-center justify-center group relative">
        <span x-show="!open" class="absolute -top-1 -right-1 flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
        </span>
        <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        <svg x-show="open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>

    <script>
        function chatbot() {
            return {
                open: false,
                userInput: '',
                // Injeta a saudação correta vinda do PHP
                messages: [
                    { role: 'assistant', content: "{{ $greeting }}" }
                ],
                isLoading: false,
                isRecording: false,
                mediaRecorder: null,
                audioChunks: [],
                recognition: null, 

                initBot() {
                    this.$watch('messages', () => {
                        this.$nextTick(() => {
                            const container = document.getElementById('chat-messages');
                            container.scrollTop = container.scrollHeight;
                        });
                    });
                },

                async sendMessage() {
                    if (!this.userInput.trim() && !this.isRecording) return;
                    
                    const textToSend = this.userInput;
                    this.messages.push({ role: 'user', content: textToSend });
                    this.userInput = '';
                    this.isLoading = true;

                    try {
                        const response = await fetch('{{ route("chatbot.send") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                message: textToSend,
                                history: this.messages.slice(-6)
                            })
                        });

                        const data = await response.json();

                        if (data.status === 'success') {
                            this.messages.push({ 
                                role: 'assistant', 
                                content: data.reply,
                                data: data.data 
                            });

                            if (data.audio) {
                                const audio = new Audio("data:audio/mp3;base64," + data.audio);
                                audio.play().catch(e => console.log("Audio play blocked"));
                            }
                        } else {
                            this.messages.push({ role: 'assistant', content: '{{ $locale == "pt" ? "Desculpe, tive um erro." : "Sorry, error occurred." }}' });
                        }

                    } catch (error) {
                        console.error(error);
                        this.messages.push({ role: 'assistant', content: '{{ $locale == "pt" ? "Erro de conexão." : "Connection error." }}' });
                    } finally {
                        this.isLoading = false;
                    }
                },

                toggleRecording() {
                    if (this.isRecording) {
                        this.stopRecording();
                    } else {
                        this.startRecording();
                    }
                },

                async startRecording() {
                    try {
                        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                            this.recognition = new SpeechRecognition();
                            // Define o idioma da voz igual ao do site
                            this.recognition.lang = '{{ $locale == "en" ? "en-US" : ($locale == "fr" ? "fr-FR" : "pt-PT") }}';
                            this.recognition.continuous = false;
                            this.recognition.interimResults = false;

                            this.recognition.onstart = () => { this.isRecording = true; };

                            this.recognition.onresult = (event) => {
                                const transcript = event.results[0][0].transcript;
                                this.userInput = transcript;
                                setTimeout(() => this.sendMessage(), 500);
                            };

                            this.recognition.onend = () => { this.isRecording = false; };
                            
                            this.recognition.start();
                        } else {
                            alert("Browser not supported for voice.");
                        }

                    } catch (err) {
                        console.error(err);
                        this.isRecording = false;
                    }
                },

                stopRecording() {
                    this.isRecording = false;
                    if (this.recognition) this.recognition.stop();
                }
            }
        }
    </script>
</div>