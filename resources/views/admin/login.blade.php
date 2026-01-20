<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Reservado | Intellectus</title>
    
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased text-white bg-brand-secondary h-screen flex items-center justify-center relative overflow-hidden selection:bg-brand-accent selection:text-brand-secondary">

    {{-- Background Imersivo (Azul Profundo) --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        {{-- Gradiente para dar profundidade --}}
        <div class="absolute inset-0 bg-gradient-to-br from-brand-secondary via-[#0f172a] to-black/90"></div>
    </div>

    {{-- Cartão de Login --}}
    <div class="w-full max-w-md relative z-10 p-10 border-t-4 border-brand-accent bg-white/5 backdrop-blur-2xl shadow-2xl rounded-sm">
        
        <div class="text-center mb-12">
            <h1 class="font-serif text-3xl mb-3 text-white tracking-wide">INTELLECTUS</h1>
            <p class="font-mono text-[9px] uppercase tracking-[0.4em] text-brand-accent flex justify-center items-center gap-3">
                <span class="w-4 h-[1px] bg-brand-accent"></span>
                Private Office Access
                <span class="w-4 h-[1px] bg-brand-accent"></span>
            </p>
        </div>

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="group">
                <label for="email" class="block text-[10px] uppercase tracking-widest text-brand-accent mb-2 opacity-70 group-focus-within:opacity-100 transition-opacity">Email Corporativo</label>
                <input type="email" name="email" id="email" required autofocus
                       class="w-full bg-black/20 border-b border-white/10 px-0 py-3 text-white text-sm focus:outline-none focus:border-brand-accent transition-all placeholder-white/10 font-light"
                       placeholder="admin@intellectus.pt">
                @error('email')
                    <span class="text-red-400 text-xs mt-2 block font-bold flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="group">
                <label for="password" class="block text-[10px] uppercase tracking-widest text-brand-accent mb-2 opacity-70 group-focus-within:opacity-100 transition-opacity">Palavra-passe</label>
                <input type="password" name="password" id="password" required
                       class="w-full bg-black/20 border-b border-white/10 px-0 py-3 text-white text-sm focus:outline-none focus:border-brand-accent transition-all placeholder-white/10 font-light">
            </div>

            <div class="flex items-center justify-between pt-2">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="remember" class="appearance-none w-3 h-3 border border-brand-accent/50 bg-transparent checked:bg-brand-accent checked:border-brand-accent transition-all relative cursor-pointer rounded-sm">
                    <span class="text-[10px] text-white/50 group-hover:text-white transition-colors uppercase tracking-wider">Manter sessão</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-brand-accent text-brand-secondary font-bold py-4 uppercase tracking-[0.2em] text-[10px] hover:bg-white hover:text-brand-secondary transition-all duration-500 shadow-lg mt-6 border border-transparent hover:border-white">
                Iniciar Sessão
            </button>
        </form>

        <div class="mt-12 text-center border-t border-white/5 pt-6">
            <a href="{{ route('home') }}" class="text-[10px] text-white/30 hover:text-white transition-colors uppercase tracking-widest flex items-center justify-center gap-2 group">
                <span class="transform group-hover:-translate-x-1 transition-transform">←</span> Voltar ao Site Público
            </a>
        </div>
    </div>

    <div class="absolute bottom-6 text-[9px] text-white/10 uppercase tracking-widest">
        &copy; {{ date('Y') }} Rui Moita Private Office • Powered by Maxsell
    </div>

</body>
</html>