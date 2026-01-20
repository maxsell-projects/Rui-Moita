@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-center mb-10">
    <div>
        <h2 class="text-3xl font-serif text-brand-secondary">Novo Ativo</h2>
        <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Adicionar propriedade ao portfólio privado</p>
    </div>
    <a href="{{ route('admin.properties.index') }}" class="px-6 py-2 border border-brand-sand/50 text-gray-500 rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-brand-sand hover:text-white transition-colors">
        Cancelar
    </a>
</div>

{{-- FORMULÁRIO --}}
<div class="max-w-6xl mx-auto pb-20">
    
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-brand-primary text-brand-primary p-4 mb-8 shadow-sm">
            <p class="font-bold text-xs uppercase tracking-wide mb-2">Atenção aos seguintes pontos:</p>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- SEÇÃO 1: IDENTIFICAÇÃO & VISIBILIDADE --}}
        <div class="bg-white p-8 shadow-sm border-t-4 border-brand-secondary relative">
            
            {{-- Switch Visibilidade --}}
            <div class="absolute top-8 right-8 flex flex-col items-end gap-3">
                <label class="relative inline-flex items-center cursor-pointer group">
                    <input type="checkbox" name="is_visible" value="1" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-secondary"></div>
                    <span class="ml-3 text-[10px] font-bold uppercase tracking-widest text-gray-400 group-hover:text-brand-secondary transition-colors">Publicar</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="rounded-sm border-gray-300 text-brand-primary focus:ring-brand-primary h-4 w-4">
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Destaque (Home)</span>
                </label>
            </div>

            <div class="flex items-center gap-3 mb-8 border-b border-gray-100 pb-4">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-brand-secondary text-white font-serif font-bold text-xs">1</span>
                <h3 class="text-lg font-serif text-brand-secondary">Identificação</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-8 pr-0 md:pr-40"> 
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">Título Comercial</label>
                    <input type="text" name="title" value="{{ old('title') }}" required 
                           class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 transition-colors text-lg font-serif text-brand-secondary placeholder-gray-300" 
                           placeholder="Ex: Penthouse Duplex no Chiado">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="group">
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">Ref. Interna</label>
                        <input type="text" name="reference_code" value="{{ old('reference_code') }}" 
                               class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 transition-colors text-sm font-mono text-brand-secondary placeholder-gray-300" 
                               placeholder="#MM-2026-001">
                    </div>
                    
                    <div class="group">
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">Tipo de Ativo</label>
                        <select name="type" class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 text-sm text-brand-secondary bg-transparent cursor-pointer">
                            <option value="Apartamento" {{ old('type') == 'Apartamento' ? 'selected' : '' }}>Apartamento</option>
                            <option value="Moradia" {{ old('type') == 'Moradia' ? 'selected' : '' }}>Moradia / Villa</option>
                            <option value="Terreno" {{ old('type') == 'Terreno' ? 'selected' : '' }}>Terreno</option>
                            <option value="Comercial" {{ old('type') == 'Comercial' ? 'selected' : '' }}>Comercial / Escritório</option>
                        </select>
                    </div>
                    
                    <div class="group">
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">Valor (€)</label>
                        <input type="number" name="price" value="{{ old('price') }}" 
                               class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 transition-colors text-lg font-serif text-brand-secondary placeholder-gray-300" 
                               placeholder="0.00">
                    </div>
                </div>
                
                <div>
                     <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-3 font-bold">Estado Comercial</label>
                     <div class="flex gap-8">
                         <label class="flex items-center gap-2 cursor-pointer group">
                             <input type="radio" name="status" value="Venda" checked class="text-brand-primary focus:ring-brand-primary border-gray-300">
                             <span class="text-xs text-gray-600 group-hover:text-brand-primary transition-colors">Para Venda</span>
                         </label>
                         <label class="flex items-center gap-2 cursor-pointer group">
                             <input type="radio" name="status" value="Arrendamento" class="text-brand-primary focus:ring-brand-primary border-gray-300">
                             <span class="text-xs text-gray-600 group-hover:text-brand-primary transition-colors">Para Arrendamento</span>
                         </label>
                     </div>
                </div>
            </div>
        </div>

        {{-- SEÇÃO 2: DETALHES TÉCNICOS --}}
        <div class="bg-white p-8 shadow-sm border-t-4 border-brand-primary">
            <div class="flex items-center gap-3 mb-8 border-b border-gray-100 pb-4">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-brand-primary text-white font-serif font-bold text-xs">2</span>
                <h3 class="text-lg font-serif text-brand-secondary">Especificações</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">Localização (Pública)</label>
                    <input type="text" name="location" value="{{ old('location') }}" 
                           class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 text-sm placeholder-gray-300" 
                           placeholder="Ex: Cascais, Quinta da Marinha">
                </div>
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">Morada (Privada)</label>
                    <input type="text" name="address" value="{{ old('address') }}" 
                           class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 text-sm placeholder-gray-300" 
                           placeholder="Rua e número exato...">
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">Área (m²)</label>
                    <input type="number" name="area_gross" value="{{ old('area_gross') }}" class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 text-sm text-center font-mono">
                </div>
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">Quartos</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 text-sm text-center font-mono">
                </div>
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">WC's</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms') }}" class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 text-sm text-center font-mono">
                </div>
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">Garagem</label>
                    <input type="number" name="garages" value="{{ old('garages') }}" class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 text-sm text-center font-mono">
                </div>
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold group-focus-within:text-brand-primary transition-colors">Cert. Energ.</label>
                    <select name="energy_rating" class="w-full border-0 border-b border-gray-200 px-0 py-2 focus:border-brand-primary focus:ring-0 text-sm text-center font-bold text-brand-secondary bg-transparent">
                        <option value="">-</option>
                        @foreach(['A+', 'A', 'B', 'B-', 'C', 'D', 'E', 'F'] as $rating)
                            <option value="{{ $rating }}" {{ old('energy_rating') == $rating ? 'selected' : '' }}>{{ $rating }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- SEÇÃO 3: AMENITIES --}}
        <div class="bg-white p-8 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-brand-secondary/10 text-brand-secondary font-serif font-bold text-xs">3</span>
                <h3 class="text-lg font-serif text-brand-secondary">Comodidades</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    'has_pool' => 'Piscina', 
                    'has_garden' => 'Jardim', 
                    'has_lift' => 'Elevador', 
                    'has_terrace' => 'Terraço',
                    'has_air_conditioning' => 'Ar Condicionado',
                    'is_furnished' => 'Mobilado',
                    'is_kitchen_equipped' => 'Cozinha Equipada'
                ] as $field => $label)
                    <label class="flex items-center gap-3 p-3 border border-dashed border-gray-200 rounded-sm cursor-pointer hover:border-brand-primary hover:bg-brand-primary/5 transition-all select-none group">
                        <input type="checkbox" name="{{ $field }}" class="accent-brand-primary w-4 h-4 rounded-sm border-gray-300 focus:ring-brand-primary text-brand-primary" {{ old($field) ? 'checked' : '' }}> 
                        <span class="text-xs font-medium text-gray-500 group-hover:text-brand-primary transition-colors">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- SEÇÃO 4: MULTIMÉDIA --}}
        <div class="bg-white p-8 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-brand-secondary/10 text-brand-secondary font-serif font-bold text-xs">4</span>
                <h3 class="text-lg font-serif text-brand-secondary">Galeria & Media</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                {{-- Foto de Capa --}}
                <div class="p-8 border-2 border-dashed border-gray-200 hover:border-brand-primary transition-colors bg-gray-50/30 text-center group">
                    <label class="block text-[10px] uppercase tracking-widest text-brand-secondary mb-4 font-bold">Foto de Capa (Principal)</label>
                    <div class="relative w-full">
                        <input type="file" name="cover_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                        <div class="py-4 px-6 bg-white border border-gray-200 shadow-sm text-xs font-bold text-gray-500 uppercase tracking-widest group-hover:text-brand-primary group-hover:border-brand-primary transition-colors">
                            Selecionar Arquivo
                        </div>
                    </div>
                </div>

                {{-- Galeria --}}
                <div class="p-8 border-2 border-dashed border-gray-200 hover:border-brand-primary transition-colors bg-gray-50/30 text-center group">
                    <label class="block text-[10px] uppercase tracking-widest text-brand-secondary mb-4 font-bold">Galeria (Múltiplas)</label>
                    <div class="relative w-full">
                        <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                        <div class="py-4 px-6 bg-white border border-gray-200 shadow-sm text-xs font-bold text-gray-500 uppercase tracking-widest group-hover:text-brand-primary group-hover:border-brand-primary transition-colors">
                            Adicionar Fotos
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="gallery-preview" class="grid grid-cols-4 md:grid-cols-6 gap-4"></div>
        </div>

        {{-- SEÇÃO 5: DESCRIÇÃO --}}
        <div class="bg-white p-8 shadow-sm border border-gray-100">
            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-4 font-bold">Descrição Editorial</label>
            <textarea name="description" rows="6" class="w-full border-gray-200 rounded-sm px-4 py-4 focus:border-brand-primary focus:ring-0 text-sm leading-relaxed placeholder-gray-300 font-light" placeholder="Escreva uma descrição detalhada e envolvente sobre o imóvel...">{{ old('description') }}</textarea>
        </div>

        {{-- SUBMIT --}}
        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-brand-primary text-white px-10 py-4 rounded-sm shadow-lg hover:bg-brand-secondary transition-all transform hover:-translate-y-1 font-bold uppercase text-[10px] tracking-[0.2em] flex items-center gap-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
                Publicar Imóvel
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT DA GALERIA --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('gallery-input');
        const previewContainer = document.getElementById('gallery-preview');
        const dt = new DataTransfer(); 

        input.addEventListener('change', function() {
            for(let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                dt.items.add(file);

                const div = document.createElement('div');
                div.className = "relative h-24 w-full rounded-sm overflow-hidden border border-gray-200 shadow-sm group bg-gray-100";
                
                const img = document.createElement('img');
                img.className = "h-full w-full object-cover opacity-80 hover:opacity-100 transition duration-500";
                
                const btn = document.createElement('button');
                btn.innerHTML = '×';
                btn.className = "absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-sm shadow-md hover:bg-red-700 focus:outline-none z-10 opacity-0 group-hover:opacity-100 transition-all duration-300";
                
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e) { img.src = e.target.result; };

                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    div.remove();
                    updateInputFiles(file);
                });

                div.appendChild(img);
                div.appendChild(btn);
                previewContainer.appendChild(div);
            }
            this.files = dt.files;
        });

        function updateInputFiles(fileToRemove) {
            const newDt = new DataTransfer();
            for (let i = 0; i < dt.files.length; i++) {
                const file = dt.files[i];
                if (file !== fileToRemove) newDt.items.add(file);
            }
            dt.items.clear();
            for (let i = 0; i < newDt.files.length; i++) dt.items.add(newDt.files[i]);
            input.files = dt.files;
        }
    });
</script>

@endsection