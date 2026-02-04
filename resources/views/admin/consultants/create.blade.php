@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h2 class="text-2xl font-serif font-bold text-intellectus-primary">Novo Membro da Equipa</h2>
            <div class="flex items-center gap-2 mt-2">
                <a href="{{ route('admin.consultants.index') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-intellectus-accent transition-colors">&larr; Voltar à Lista</a>
            </div>
        </div>

        <div class="bg-white p-8 rounded-sm shadow-sm border border-gray-100">
            <form method="POST" action="{{ route('admin.consultants.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Foto --}}
                <div class="mb-6 text-center">
                    <label class="block text-xs font-bold uppercase tracking-widest text-intellectus-accent mb-2">Fotografia</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-sm p-6 hover:bg-gray-50 transition-colors">
                        <input type="file" name="photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:uppercase file:font-bold file:bg-intellectus-primary file:text-white hover:file:bg-intellectus-accent cursor-pointer">
                    </div>
                    @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Nome --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Nome Completo</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary placeholder-gray-300 transition-colors" placeholder="Ex: Ana Silva">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Cargo --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Cargo / Função</label>
                        <input type="text" name="role" value="{{ old('role') }}" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary placeholder-gray-300 transition-colors" placeholder="Ex: Senior Consultant">
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Email Profissional</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary placeholder-gray-300 transition-colors">
                    </div>

                    {{-- Telefone --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Telefone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary placeholder-gray-300 transition-colors">
                    </div>
                </div>

                {{-- Bio --}}
                <div class="mb-6">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Biografia Curta</label>
                    <textarea name="bio" rows="4" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary placeholder-gray-300 transition-colors resize-none" placeholder="Breve descrição do percurso profissional..."></textarea>
                </div>

                {{-- LinkedIn --}}
                <div class="mb-8">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">LinkedIn (URL)</label>
                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url') }}" class="w-full border-0 border-b border-gray-200 focus:border-intellectus-accent focus:ring-0 px-0 py-2 text-intellectus-primary placeholder-gray-300 transition-colors">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-intellectus-primary hover:bg-intellectus-accent text-white font-bold py-3 px-8 rounded-sm shadow-lg transition-all duration-300 uppercase tracking-widest text-xs">
                        Guardar Membro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection