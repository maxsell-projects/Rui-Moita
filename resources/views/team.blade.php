@extends('layouts.app')

@section('title', 'A Nossa Equipa')

@section('content')
{{-- Hero Section --}}
<section class="relative py-24 md:py-32 bg-brand-secondary text-white overflow-hidden">
    {{-- Background Pattern Subtle --}}
    <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    <div class="container mx-auto px-6 relative z-10 text-center">
        <p class="text-brand-accent uppercase tracking-[0.3em] text-xs font-bold mb-4 animate-fade-in-up">Intellectus Private Office</p>
        <h1 class="font-serif text-4xl md:text-6xl mb-6 leading-tight animate-fade-in-up delay-100">
            Os nossos especialistas.
        </h1>
        <div class="w-24 h-[1px] bg-brand-accent mx-auto mb-6"></div>
        <p class="font-light text-lg text-white/80 max-w-2xl mx-auto animate-fade-in-up delay-200">
            Uma equipa multidisciplinar unida pela paixão, integridade e pela busca incessante da excelência no mercado imobiliário de luxo.
        </p>
    </div>
</section>

{{-- Team Grid --}}
<section class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-16">
            @forelse($consultants as $consultant)
                <div class="group">
                    {{-- Card Image --}}
                    <div class="relative overflow-hidden mb-6">
                        <div class="aspect-[3/4] bg-gray-100 relative">
                            <img src="{{ $consultant->photo_url }}" 
                                 alt="{{ $consultant->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 filter grayscale group-hover:grayscale-0">
                            
                            {{-- Social Overlay --}}
                            <div class="absolute inset-0 bg-brand-secondary/90 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col items-center justify-center gap-6 translate-y-4 group-hover:translate-y-0 transform">
                                @if($consultant->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $consultant->whatsapp) }}" target="_blank" class="text-white hover:text-brand-accent transition-colors flex items-center gap-3 group/link">
                                        <i class="fab fa-whatsapp text-xl"></i> 
                                        <span class="text-xs uppercase tracking-widest font-bold">WhatsApp</span>
                                    </a>
                                @endif
                                @if($consultant->email)
                                    <a href="mailto:{{ $consultant->email }}" class="text-white hover:text-brand-accent transition-colors flex items-center gap-3 group/link">
                                        <i class="far fa-envelope text-xl"></i>
                                        <span class="text-xs uppercase tracking-widest font-bold">Email</span>
                                    </a>
                                @endif
                                <div class="flex gap-4 mt-4">
                                    @if($consultant->linkedin) <a href="{{ $consultant->linkedin }}" target="_blank" class="text-white/50 hover:text-white"><i class="fab fa-linkedin text-lg"></i></a> @endif
                                    @if($consultant->instagram) <a href="{{ $consultant->instagram }}" target="_blank" class="text-white/50 hover:text-white"><i class="fab fa-instagram text-lg"></i></a> @endif
                                    @if($consultant->tiktok) <a href="{{ $consultant->tiktok }}" target="_blank" class="text-white/50 hover:text-white"><i class="fab fa-tiktok text-lg"></i></a> @endif
                                </div>
                            </div>
                        </div>
                        {{-- Border Accent --}}
                        <div class="absolute bottom-0 left-0 w-full h-1 bg-brand-accent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    </div>

                    {{-- Info --}}
                    <div class="text-center">
                        <h3 class="font-serif text-2xl text-brand-secondary group-hover:text-brand-primary transition-colors">{{ $consultant->name }}</h3>
                        <p class="text-xs uppercase tracking-[0.2em] text-brand-accent font-bold mt-2">{{ $consultant->role }}</p>
                        
                        @if($consultant->bio)
                            <p class="text-sm text-gray-500 font-light mt-4 leading-relaxed line-clamp-3 px-4">
                                {{ $consultant->bio }}
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20">
                    <p class="text-gray-400 font-serif italic text-xl">A equipa está a ser atualizada.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA Recruitment --}}
<section class="py-20 bg-gray-50 border-t border-gray-200">
    <div class="container mx-auto px-6 text-center">
        <h2 class="font-serif text-3xl text-brand-secondary mb-4">Tem o perfil Intellectus?</h2>
        <p class="text-gray-500 font-light mb-8">Estamos sempre à procura de talento excecional para integrar a nossa equipa.</p>
        <a href="{{ route('recruitment') }}" class="inline-block px-8 py-4 bg-brand-secondary text-white uppercase text-xs font-bold tracking-[0.2em] hover:bg-brand-accent hover:text-brand-secondary transition-all">
            Trabalhe Connosco
        </a>
    </div>
</section>
@endsection