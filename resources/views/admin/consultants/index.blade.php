@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-serif font-bold text-intellectus-primary">{{ __('messages.team') }}</h2>
                <p class="text-sm text-gray-500 font-light mt-1">Gerencie a equipa e os perfis públicos.</p>
            </div>
            <a href="{{ route('admin.consultants.create') }}" class="inline-flex items-center px-4 py-2 bg-intellectus-accent text-intellectus-base rounded-sm shadow-sm text-xs font-bold uppercase tracking-widest hover:bg-intellectus-primary hover:text-white transition-all duration-300">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Adicionar Membro
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 shadow-sm mb-6 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm border border-gray-100">
            <div class="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-intellectus-surface">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">Membro</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">Cargo</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">Contactos</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-gray-400">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($consultants as $consultant)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-full overflow-hidden border border-gray-200">
                                            @if($consultant->photo)
                                                <img class="h-full w-full object-cover" src="{{ Storage::url($consultant->photo) }}" alt="{{ $consultant->name }}">
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-gray-300 font-serif font-bold">
                                                    {{ substr($consultant->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold font-serif text-intellectus-primary">{{ $consultant->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $consultant->role }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-500">{{ $consultant->email }}</div>
                                    <div class="text-xs text-gray-400">{{ $consultant->phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.consultants.edit', $consultant) }}" class="text-intellectus-primary hover:text-intellectus-accent transition-colors" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.consultants.destroy', $consultant) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja remover este membro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" title="Apagar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-xs uppercase tracking-widest text-gray-400">
                                    Nenhum consultor registado.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection