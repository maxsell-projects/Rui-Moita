@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-serif text-brand-secondary">Editar: {{ $consultant->name }}</h2>
        </div>
        <a href="{{ route('admin.consultants.index') }}" class="flex items-center gap-2 text-[10px] font-bold text-gray-400 hover:text-brand-secondary uppercase tracking-widest transition-colors">
            Voltar
        </a>
    </div>

    <form action="{{ route('admin.consultants.update', $consultant) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 md:p-10 shadow-sm rounded-sm border border-gray-100">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Nome Completo</label>
                        <input type="text" name="name" value="{{ old('name', $consultant->name) }}" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-sm py-3 px-4" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Cargo</label>
                        <input type="text" name="role" value="{{ old('role', $consultant->role) }}" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-sm py-3 px-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Email</label>
                        <input type="email" name="email" value="{{ old('email', $consultant->email) }}" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-sm py-3 px-4">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Telefone</label>
                        <input type="text" name="phone" value="{{ old('phone', $consultant->phone) }}" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-sm py-3 px-4">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Biografia</label>
                    <textarea name="bio" rows="6" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-sm p-4">{{ old('bio', $consultant->bio) }}</textarea>
                </div>

                <div class="pt-6 border-t border-gray-50">
                    <h3 class="text-xs font-bold uppercase text-brand-secondary tracking-widest mb-4">Redes Sociais</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fab fa-whatsapp"></i></span>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $consultant->whatsapp) }}" placeholder="WhatsApp" class="w-full pl-8 border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-xs py-2.5">
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fab fa-linkedin"></i></span>
                            <input type="url" name="linkedin" value="{{ old('linkedin', $consultant->linkedin) }}" placeholder="LinkedIn" class="w-full pl-8 border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-xs py-2.5">
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fab fa-instagram"></i></span>
                            <input type="url" name="instagram" value="{{ old('instagram', $consultant->instagram) }}" placeholder="Instagram" class="w-full pl-8 border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-xs py-2.5">
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400"><i class="fab fa-tiktok"></i></span>
                            <input type="url" name="tiktok" value="{{ old('tiktok', $consultant->tiktok) }}" placeholder="TikTok" class="w-full pl-8 border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-xs py-2.5">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-50 p-6 border border-gray-100 rounded-sm">
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-3 tracking-wider text-center">Fotografia Atual</label>
                    
                    <div class="relative w-full aspect-square bg-white border-2 border-dashed border-gray-300 rounded-sm flex flex-col items-center justify-center overflow-hidden cursor-pointer group">
                        <input type="file" name="photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                        
                        <img id="image-preview" src="{{ $consultant->photo_url }}" alt="Preview" class="absolute inset-0 w-full h-full object-cover">
                        
                        {{-- Overlay on Hover --}}
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                            <span class="text-white text-[10px] uppercase font-bold">Alterar Foto</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 border border-gray-100 rounded-sm space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 tracking-wider">Ordem</label>
                        <input type="number" name="order" value="{{ old('order', $consultant->order) }}" class="w-full border-gray-200 focus:border-brand-accent focus:ring-0 rounded-sm text-center font-bold text-lg">
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wide">Visível?</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $consultant->is_active ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-accent"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-8 mt-8 border-t border-gray-100">
            <button type="submit" class="bg-brand-secondary text-white px-10 py-4 uppercase text-[10px] font-bold tracking-[0.2em] hover:bg-brand-primary transition-all shadow-lg">
                Atualizar Dados
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
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection