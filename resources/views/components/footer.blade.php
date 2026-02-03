<footer class="bg-graphite text-white pt-16 pb-8 border-t border-gray-800">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-12 mb-12">
            
            {{-- BRANDING & SOCIAL --}}
            <div>
                <div class="font-heading text-2xl font-bold mb-4">
                    <span class="text-white">CROW</span>
                    <span class="text-accent"> GLOBAL</span>
                </div>
                <p class="text-white/70 text-sm leading-relaxed mb-4">
                    {{ __('Premium real estate investments connecting global capital to Portugal\'s most exclusive markets.') }}
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-accent/20 transition-colors" aria-label="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-accent/20 transition-colors" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-accent/20 transition-colors" aria-label="LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </div>

            {{-- QUICK LINKS --}}
            <div>
                <h3 class="font-heading text-lg font-semibold mb-4">{{ __('Quick Links') }}</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}#about" class="text-white/70 hover:text-accent transition-colors text-sm">{{ __('About Us') }}</a></li>
                    <li><a href="{{ route('home') }}#municipalities" class="text-white/70 hover:text-accent transition-colors text-sm">{{ __('Municipalities') }}</a></li>
                    <li><a href="{{ route('home') }}#services" class="text-white/70 hover:text-accent transition-colors text-sm">{{ __('Services') }}</a></li>
                    <li><a href="{{ route('home') }}#contact" class="text-white/70 hover:text-accent transition-colors text-sm">{{ __('Contact') }}</a></li>
                </ul>
            </div>

            {{-- LEGAL INFO --}}
            <div>
                <h3 class="font-heading text-lg font-semibold mb-4">{{ __('Legal Info') }}</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('legal.privacy') }}" class="text-white/70 hover:text-accent transition-colors text-sm">{{ __('legal.privacy.title') }}</a></li>
                    <li><a href="{{ route('legal.terms') }}" class="text-white/70 hover:text-accent transition-colors text-sm">{{ __('legal.terms.title') }}</a></li>
                    <li><a href="{{ route('legal.cookies') }}" class="text-white/70 hover:text-accent transition-colors text-sm">{{ __('legal.cookies.title') }}</a></li>
                    <li><a href="{{ route('legal.notice') }}" class="text-white/70 hover:text-accent transition-colors text-sm">{{ __('legal.notice.title') }}</a></li>
                    
                    {{-- ADIÇÃO: LIVRO DE RECLAMAÇÕES --}}
                    <li class="pt-2">
                        <a href="https://www.livroreclamacoes.pt/Inicio/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-white/70 hover:text-accent transition-colors text-sm group">
                            {{ __('Complaints Book') }}
                            <svg class="w-3 h-3 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- CONTACT --}}
            <div>
                <h3 class="font-heading text-lg font-semibold mb-4">{{ __('Contact') }}</h3>
                <ul class="space-y-4"> {{-- Aumentei um pouco o espaçamento aqui --}}
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-white/70 text-sm">Avenida da Liberdade 123<br />1250-140 Lisboa, Portugal</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span class="text-white/70 text-sm">+351 21 123 4567</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-white/70 text-sm">info@crowglobal.pt</span>
                    </li>

                    {{-- ADIÇÃO: HORÁRIO DE FUNCIONAMENTO --}}
                    <li class="flex items-start gap-3 border-t border-white/10 pt-4 mt-2">
                        <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="text-white/70 text-sm">
                            <span class="block text-white font-bold text-xs uppercase tracking-wider mb-1">{{ __('Opening Hours') }}</span>
                            <span class="block">{{ __('Mon - Fri') }}: 09:00 - 18:00</span>
                            <span class="block">{{ __('Weekends') }}: <span class="italic text-white/50">{{ __('By appointment') }}</span></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
            
            <p class="text-white/60 text-sm text-center md:text-left">
                © {{ date('Y') }} Crow Global Investments. {{ __('All rights reserved.') }}
            </p>

            <div class="flex items-center gap-3 opacity-40 hover:opacity-100 transition-all duration-500 group cursor-pointer" title="Developed by MaxSell">
                <span class="text-[10px] text-white/50 uppercase tracking-widest group-hover:text-white transition-colors hidden md:block">
                    Technology by
                </span>
                <img src="{{ asset('images/maxsell.png') }}" 
                     alt="MaxSell" 
                     class="h-6 w-auto grayscale group-hover:grayscale-0 transition-all duration-500">
            </div>

        </div>
    </div>
</footer>