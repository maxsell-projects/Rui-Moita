@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8">
                <h2 class="text-2xl font-serif font-bold text-intellectus-primary">
                    {{ __('messages.edit') }}: <span class="font-light italic">{{ $property->title }}</span>
                </h2>
                <div class="flex items-center gap-2 mt-2">
                    <a href="{{ route('admin.properties.index') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-intellectus-accent transition-colors">&larr; {{ __('messages.back') }}</a>
                </div>
            </div>

            <form method="POST" action="{{ route('properties.update', $property) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- Coluna Principal (Esquerda) --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        {{-- Informações Principais --}}
                        <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100">
                            <h3 class="text-lg font-serif font-bold text-intellectus-primary mb-6 border-b border-gray-100 pb-2">{{ __('messages.main_info') }}</h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.title_label') }}</label>
                                    <input type="text" name="title" value="{{ old('title', $property->title) }}" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary placeholder-gray-400 transition-colors">
                                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.description_label') }}</label>
                                    <textarea name="description" rows="5" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary placeholder-gray-400 transition-colors resize-none">{{ old('description', $property->description) }}</textarea>
                                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Status --}}
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.status_label') }}</label>
                                        <select name="status" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary bg-transparent font-bold">
                                            <option value="draft" {{ $property->status == 'draft' ? 'selected' : '' }}>{{ __('messages.draft') }}</option>
                                            <option value="active" {{ $property->status == 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                                            <option value="negotiating" {{ $property->status == 'negotiating' ? 'selected' : '' }}>⚠ {{ __('messages.negotiating') }}</option>
                                            <option value="sold" {{ $property->status == 'sold' ? 'selected' : '' }}>{{ __('Sold') }}</option>
                                        </select>
                                        @if($property->status == 'negotiating')
                                            <p class="text-[10px] text-orange-500 mt-1 font-bold">{{ __('messages.negotiating_text') }}</p>
                                        @endif
                                    </div>

                                    {{-- Preço --}}
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.price_label') }}</label>
                                        <input type="number" name="price" value="{{ old('price', $property->price) }}" required min="0" step="0.01" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 font-serif font-bold text-lg text-intellectus-primary">
                                    </div>

                                    {{-- Tipo --}}
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.type_label') }}</label>
                                        <select name="type" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary bg-transparent">
                                            @foreach(['apartment','house','villa','land','commercial','office'] as $t)
                                                <option value="{{ $t }}" {{ $property->type == $t ? 'selected' : '' }}>{{ __('messages.'.$t) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Transação --}}
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.transaction_label') }}</label>
                                        <select name="transaction_type" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary bg-transparent">
                                            <option value="sale" {{ $property->transaction_type == 'sale' ? 'selected' : '' }}>{{ __('messages.sale') }}</option>
                                            <option value="rent" {{ $property->transaction_type == 'rent' ? 'selected' : '' }}>{{ __('messages.rent') }}</option>
                                        </select>
                                    </div>
                                    
                                    {{-- Condição --}}
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.condition_label') }}</label>
                                        <select name="condition" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary bg-transparent">
                                            <option value="new" {{ $property->condition == 'new' ? 'selected' : '' }}>{{ __('messages.new') }}</option>
                                            <option value="used" {{ $property->condition == 'used' ? 'selected' : '' }}>{{ __('messages.used') }}</option>
                                            <option value="renovated" {{ $property->condition == 'renovated' ? 'selected' : '' }}>{{ __('messages.renovated') }}</option>
                                            <option value="under_construction" {{ $property->condition == 'under_construction' ? 'selected' : '' }}>{{ __('messages.under_construction') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detalhes e Áreas --}}
                        <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100">
                            <h3 class="text-lg font-serif font-bold text-intellectus-primary mb-6 border-b border-gray-100 pb-2">{{ __('messages.details_areas') }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ __('messages.bedrooms') }}</label>
                                    <input type="number" name="bedrooms" value="{{ $property->bedrooms }}" min="0" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ __('messages.bathrooms') }}</label>
                                    <input type="number" name="bathrooms" value="{{ $property->bathrooms }}" min="0" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ __('messages.area') }} (m²)</label>
                                    <input type="number" name="area" value="{{ $property->area }}" min="0" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ __('messages.year_built') }}</label>
                                    <input type="number" name="year_built" value="{{ $property->year_built }}" min="1800" max="{{ date('Y') }}" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                            </div>
                            
                            <h3 class="text-lg font-serif font-bold text-intellectus-primary mb-6 border-b border-gray-100 pb-2 mt-8">{{ __('messages.location') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.city') }}</label>
                                    <input type="text" name="city" value="{{ $property->city }}" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.address') }}</label>
                                    <input type="text" name="address" value="{{ $property->address }}" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Coluna Lateral (Direita) --}}
                    <div class="lg:col-span-1 space-y-6">
                        
                        {{-- Imagem de Capa --}}
                        <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100">
                            <h3 class="text-lg font-serif font-bold text-intellectus-primary mb-4">{{ __('messages.current_cover') }}</h3>
                            
                            @if($property->cover_image)
                                <div class="relative group mb-4">
                                    <img src="{{ Storage::url($property->cover_image) }}" class="w-full h-48 object-cover rounded-sm shadow-sm">
                                </div>
                            @endif
                            
                            <label class="block text-xs font-bold uppercase tracking-widest text-intellectus-accent mb-2">{{ __('messages.change_cover') }}</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:uppercase file:font-bold file:bg-intellectus-accent file:text-white hover:file:bg-intellectus-primary">
                        </div>

                        {{-- Galeria --}}
                        <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100">
                            <h3 class="text-lg font-serif font-bold text-intellectus-primary mb-4">{{ __('messages.gallery_label') }}</h3>
                            
                            @if($property->images && count($property->images) > 0)
                                <div class="grid grid-cols-2 gap-2 mb-4">
                                    @foreach($property->images as $img)
                                        <div class="relative group">
                                            <img src="{{ Storage::url($img) }}" class="w-full h-24 object-cover rounded-sm border border-gray-100">
                                            
                                            {{-- Overlay para Deletar --}}
                                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-sm">
                                                <label class="flex flex-col items-center gap-1 text-white cursor-pointer p-2">
                                                    <input type="checkbox" name="delete_images[]" value="{{ $img }}" class="h-5 w-5 text-red-500 border-gray-300 rounded focus:ring-red-500">
                                                    <span class="text-[9px] uppercase font-bold tracking-widest">{{ __('messages.delete_selected') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-[10px] text-gray-400 mb-4 italic">{{ __('messages.delete_hint') }}</p>
                            @endif

                            <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">{{ __('messages.add_photos') }}</label>
                            <input type="file" name="images[]" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:uppercase file:font-bold file:bg-gray-600 file:text-white hover:file:bg-gray-700">
                        </div>

                        {{-- Redes Sociais / Video --}}
                        <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100">
                            <div class="mb-4">
                                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.video_label') }}</label>
                                <input type="url" name="video_url" value="{{ old('video_url', $property->video_url) }}" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-bold uppercase tracking-widest text-green-700 mb-1 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    {{ __('messages.whatsapp_label') }}
                                </label>
                                <input type="text" name="whatsapp" value="{{ old('whatsapp', $property->whatsapp) }}" class="w-full border-0 border-b border-green-200 focus:border-green-500 focus:ring-0 px-0 py-2 text-green-800 bg-green-50/50">
                            </div>
                        </div>

                        {{-- Visibilidade --}}
                        <div class="bg-intellectus-primary p-6 rounded-sm shadow-xl text-white">
                            <h3 class="text-lg font-serif font-bold mb-4 border-b border-gray-700 pb-2">{{ __('messages.visibility_card') }}</h3>
                            
                            <div class="flex items-start mb-6">
                                <div class="flex h-5 items-center">
                                    <input id="is_exclusive" name="is_exclusive" type="checkbox" value="1" {{ $property->is_exclusive ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-600 bg-gray-700 text-intellectus-accent focus:ring-intellectus-accent">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_exclusive" class="font-bold text-white uppercase tracking-wider">{{ __('messages.exclusive_label') }}</label>
                                    <p class="text-gray-400 text-xs mt-1">{{ __('messages.exclusive_text') }}</p>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-intellectus-accent hover:bg-white hover:text-intellectus-primary text-intellectus-base font-bold py-3 px-6 rounded-sm shadow-lg transition-all duration-300 uppercase tracking-widest text-xs">
                                {{ __('messages.save_changes') }}
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection