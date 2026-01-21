@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-serif text-brand-secondary">Novo Consultor</h2>
            <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">Adicionar membro à equipa</p>
        </div>
        <a href="{{ route('admin.consultants.index') }}" class="flex items-center gap-2 text-[10px] font-bold text-gray-400 hover:text-brand-secondary uppercase tracking-widest transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Voltar
        </a>
    </div>

    <form action="{{ route('admin.consultants.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 md:p-10 shadow-sm rounded-sm border border-gray-100">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            {{-- Coluna Esquerda: Dados Principais --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Nome Completo <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-sm py-3 px-4" placeholder="Ex: Ana Silva" required>
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Cargo</label>
                        <input type="text" name="role" value="{{ old('role', 'Consultor Imobiliário') }}" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-sm py-3 px-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Email Profissional</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-sm py-3 px-4">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Telefone / Telemóvel</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-sm py-3 px-4">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Biografia (Pública)</label>
                    <textarea name="bio" rows="6" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-sm p-4" placeholder="Breve descrição profissional...">{{ old('bio') }}</textarea>
                    <p class="text-[9px] text-gray-400 mt-1 text-right">Recomendado: Máx 300 caracteres.</p>
                </div>

                {{-- Redes Sociais --}}
                <div class="pt-6 border-t border-gray-50">
                    <h3 class="text-xs font-bold uppercase text-brand-secondary tracking-widest mb-4">Redes Sociais & Contactos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fab fa-whatsapp"></i></span>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="WhatsApp (só números, ex: 351912345678)" class="w-full pl-8 border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-xs py-2.5">
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fab fa-linkedin"></i></span>
                            <input type="url" name="linkedin" value="{{ old('linkedin') }}" placeholder="LinkedIn URL" class="w-full pl-8 border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-xs py-2.5">
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fab fa-instagram"></i></span>
                            <input type="url" name="instagram" value="{{ old('instagram') }}" placeholder="Instagram URL" class="w-full pl-8 border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-xs py-2.5">
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fab fa-tiktok"></i></span>
                            <input type="url" name="tiktok" value="{{ old('tiktok') }}" placeholder="TikTok URL" class="w-full pl-8 border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-xs py-2.5">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Coluna Direita: Foto e Definições --}}
            <div class="space-y-6">
                <div class="bg-gray-50 p-6 border border-gray-100 rounded-sm">
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-3 tracking-wider text-center">Fotografia de Perfil</label>
                    
                    <div class="relative w-full aspect-square bg-white border-2 border-dashed border-gray-300 rounded-sm flex flex-col items-center justify-center text-gray-400 hover:border-brand-accent hover:text-brand-accent transition-colors cursor-pointer group overflow-hidden">
                        <input type="file" name="photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                        
                        <div id="image-placeholder" class="flex flex-col items-center">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-[9px] uppercase font-bold">Carregar Foto</span>
                        </div>
                        <img id="image-preview" src="#" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden">
                    </div>
                    <p class="text-[9px] text-gray-400 mt-2 text-center">JPG, PNG (Max 5MB)</p>
                </div>

                <div class="p-6 border border-gray-100 rounded-sm space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Ordem de Exibição</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-center font-bold text-lg">
                        <p class="text-[9px] text-gray-400 mt-1">Números menores aparecem primeiro.</p>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wide">Visível no Site?</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-accent"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-8 mt-8 border-t border-gray-100">
            <button type="submit" class="bg-brand-secondary text-white px-10 py-4 uppercase text-[10px] font-bold tracking-[0.2em] hover:bg-brand-primary transition-all shadow-lg">
                Adicionar Consultor
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('image-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection