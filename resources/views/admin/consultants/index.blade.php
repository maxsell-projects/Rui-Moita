@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-serif text-brand-secondary">Gestão de Equipa</h2>
        <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">Private Office Staff</p>
    </div>
    <a href="{{ route('admin.consultants.create') }}" 
       class="px-6 py-3 bg-brand-accent text-brand-secondary font-bold uppercase text-[10px] tracking-[0.2em] hover:bg-white transition-all shadow-md border border-transparent hover:border-brand-accent">
        + Novo Membro
    </a>
</div>

<div class="bg-white shadow-sm rounded-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-brand-secondary text-white uppercase text-[9px] tracking-widest font-medium">
            <tr>
                <th class="p-5 font-light">Consultor</th>
                <th class="p-5 font-light">Cargo</th>
                <th class="p-5 font-light text-center">Ordem</th>
                <th class="p-5 font-light text-center">Estado</th>
                <th class="p-5 font-light text-right">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
            @forelse($consultants as $consultant)
            <tr class="hover:bg-gray-50 transition-colors group">
                <td class="p-5">
                    <div class="flex items-center gap-4">
                        <img src="{{ $consultant->photo_url }}" alt="" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm group-hover:border-brand-accent transition-colors">
                        <div>
                            <p class="font-bold text-brand-secondary font-serif text-base">{{ $consultant->name }}</p>
                            <p class="text-xs text-gray-400 font-light">{{ $consultant->email ?? 'Sem email' }}</p>
                        </div>
                    </div>
                </td>
                <td class="p-5 text-xs font-bold uppercase tracking-wider text-gray-500">{{ $consultant->role }}</td>
                <td class="p-5 text-center font-mono text-xs text-brand-accent font-bold">{{ $consultant->order }}</td>
                <td class="p-5 text-center">
                    @if($consultant->is_active)
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-50 text-green-700 text-[9px] font-bold uppercase tracking-widest border border-green-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Ativo
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-50 text-gray-500 text-[9px] font-bold uppercase tracking-widest border border-gray-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Oculto
                        </span>
                    @endif
                </td>
                <td class="p-5 text-right">
                    <div class="flex items-center justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.consultants.edit', $consultant) }}" class="text-brand-secondary hover:text-brand-accent transition-colors" title="Editar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.consultants.destroy', $consultant) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja remover este membro da equipa?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" title="Remover">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-10 text-center text-gray-400 italic">
                    Nenhum consultor registado.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 bg-gray-50 border-t border-gray-100">
        {{ $consultants->links() }}
    </div>
</div>
@endsection