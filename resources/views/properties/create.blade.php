@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8">
                <h2 class="text-2xl font-serif font-bold text-intellectus-primary">
                    {{ __('messages.add_property') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Fill in the details below to add a new property to the portfolio.') }}</p>
            </div>

            <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- Coluna Principal (Esquerda) --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        {{-- Informações Principais --}}
                        <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100">
                            <h3 class="text-lg font-serif font-bold text-intellectus-primary mb-6 border-b border-gray-100 pb-2">{{ __('messages.main_info') }}</h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.title_label') }}</label>
                                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary placeholder-gray-400 transition-colors" placeholder="{{ __('messages.title_placeholder') }}">
                                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.description_label') }}</label>
                                    <textarea name="description" rows="5" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary placeholder-gray-400 transition-colors resize-none" placeholder="{{ __('messages.description_placeholder') }}"></textarea>
                                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.type_label') }}</label>
                                        <select name="type" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary bg-transparent">
                                            <option value="">{{ __('messages.select') }}</option>
                                            <option value="apartment">{{ __('messages.apartment') }}</option>
                                            <option value="house">{{ __('messages.house') }}</option>
                                            <option value="villa">{{ __('messages.villa') }}</option>
                                            <option value="land">{{ __('messages.land') }}</option>
                                            <option value="commercial">{{ __('messages.commercial') }}</option>
                                            <option value="office">{{ __('messages.office') }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.transaction_label') }}</label>
                                        <select name="transaction_type" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary bg-transparent">
                                            <option value="sale">{{ __('messages.sale') }}</option>
                                            <option value="rent">{{ __('messages.rent') }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.condition_label') }}</label>
                                        <select name="condition" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary bg-transparent">
                                            <option value="new">{{ __('messages.new') }}</option>
                                            <option value="used">{{ __('messages.used') }}</option>
                                            <option value="renovated">{{ __('messages.renovated') }}</option>
                                            <option value="under_construction">{{ __('messages.under_construction') }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.price_label') }}</label>
                                        <input type="number" name="price" value="{{ old('price') }}" required min="0" step="0.01" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 font-serif font-bold text-lg text-intellectus-primary placeholder-gray-400" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detalhes e Áreas --}}
                        <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100">
                            <h3 class="text-lg font-serif font-bold text-intellectus-primary mb-6 border-b border-gray-100 pb-2">{{ __('messages.details_areas') }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ __('messages.bedrooms') }}</label>
                                    <input type="number" name="bedrooms" min="0" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ __('messages.bathrooms') }}</label>
                                    <input type="number" name="bathrooms" min="0" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ __('messages.area') }} (m²)</label>
                                    <input type="number" name="area" min="0" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ __('messages.land_area') }} (m²)</label>
                                    <input type="number" name="land_area" min="0" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ __('messages.year_built') }}</label>
                                    <input type="number" name="year_built" min="1800" max="{{ date('Y') }}" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ __('messages.energy_rating') }}</label>
                                    <select name="energy_rating" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary bg-transparent">
                                        <option value="">-</option>
                                        <option value="A+">A+</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Localização --}}
                        <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100">
                            <h3 class="text-lg font-serif font-bold text-intellectus-primary mb-6 border-b border-gray-100 pb-2">{{ __('messages.location') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.city') }}</label>
                                    <select name="city" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary bg-transparent">
                                        <option value="Lisboa">Lisboa</option>
                                        <option value="Porto">Porto</option>
                                        <option value="Cascais">Cascais</option>
                                        <option value="Sintra">Sintra</option>
                                        <option value="Faro">Faro</option>
                                        <option value="Coimbra">Coimbra</option>
                                        <option value="Braga">Braga</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.district') }}</label>
                                    <input type="text" name="district" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary" placeholder="{{ __('messages.district_placeholder') }}">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.address') }}</label>
                                    <input type="text" name="address" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.postal_code') }}</label>
                                    <input type="text" name="postal_code" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary">
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Coluna Lateral (Direita) --}}
                    <div class="lg:col-span-1 space-y-6">
                        
                        <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100">
                            <h3 class="text-lg font-serif font-bold text-intellectus-primary mb-6 border-b border-gray-100 pb-2">{{ __('messages.media_contact') }}</h3>
                            
                            <div class="mb-6">
                                <label class="block text-xs font-bold uppercase tracking-widest text-intellectus-accent mb-2">{{ __('messages.cover_image_label') }}</label>
                                <div class="border-2 border-dashed border-intellectus-accent/30 bg-intellectus-accent/5 rounded-sm p-4 text-center hover:bg-intellectus-accent/10 transition-colors">
                                    <input type="file" name="cover_image" required accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:uppercase file:font-bold file:bg-intellectus-accent file:text-white hover:file:bg-intellectus-primary">
                                    <p class="text-[10px] text-gray-400 mt-2">{{ __('messages.cover_image_desc') }}</p>
                                </div>
                                @error('cover_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">{{ __('messages.gallery_label') }}</label>
                                <div class="border-2 border-dashed border-gray-200 rounded-sm p-4 text-center hover:bg-gray-50 transition-colors">
                                    <input type="file" name="images[]" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:uppercase file:font-bold file:bg-gray-600 file:text-white hover:file:bg-gray-700">
                                    <p class="text-[10px] text-gray-400 mt-2">{{ __('messages.gallery_desc') }}</p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">{{ __('messages.video_label') }}</label>
                                <input type="url" name="video_url" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary" placeholder="https://youtube.com/...">
                                <p class="text-[10px] text-gray-400 mt-1">{{ __('messages.video_desc') }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold uppercase tracking-widest text-green-700 mb-1 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    {{ __('messages.whatsapp_label') }}
                                </label>
                                <input type="text" name="whatsapp" class="w-full border-0 border-b border-green-200 focus:border-green-500 focus:ring-0 px-0 py-2 text-green-800 bg-green-50/50" placeholder="+351 912 345 678">
                                <p class="text-[10px] text-gray-400 mt-1">{{ __('messages.whatsapp_desc') }}</p>
                            </div>
                        </div>

                        <div class="bg-intellectus-primary p-6 rounded-sm shadow-xl text-white">
                            <h3 class="text-lg font-serif font-bold mb-4 border-b border-gray-700 pb-2">{{ __('messages.visibility_card') }}</h3>
                            
                            <div class="flex items-start mb-6">
                                <div class="flex h-5 items-center">
                                    <input id="is_exclusive" name="is_exclusive" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-600 bg-gray-700 text-intellectus-accent focus:ring-intellectus-accent">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_exclusive" class="font-bold text-white uppercase tracking-wider">{{ __('messages.exclusive_label') }}</label>
                                    <p class="text-gray-400 text-xs mt-1">{{ __('messages.exclusive_text') }}</p>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-intellectus-accent hover:bg-white hover:text-intellectus-primary text-intellectus-base font-bold py-3 px-6 rounded-sm shadow-lg transition-all duration-300 uppercase tracking-widest text-xs">
                                {{ __('messages.publish') }}
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection