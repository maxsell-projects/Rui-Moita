<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminConsultantController extends Controller
{
    /**
     * Lista todos os consultores no Backoffice.
     */
    public function index()
    {
        // Ordena por 'order' ascendente para refletir a ordem do site
        $consultants = Consultant::orderBy('order', 'asc')->paginate(20);
        return view('admin.consultants.index', compact('consultants'));
    }

    /**
     * Mostra o formulário de criação.
     */
    public function create()
    {
        return view('admin.consultants.create');
    }

    /**
     * Guarda um novo consultor na BD.
     */
    public function store(Request $request)
    {
        // 1. Validação Robusta
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|max:255',
            'phone'     => 'nullable|string|max:20',
            'role'      => 'nullable|string|max:100',
            'photo'     => 'nullable|image|max:5120', // Max 5MB
            'bio'       => 'nullable|string',
            'instagram' => 'nullable|url|max:255',
            'facebook'  => 'nullable|url|max:255',
            'linkedin'  => 'nullable|url|max:255',
            'tiktok'    => 'nullable|url|max:255',
            'whatsapp'  => 'nullable|string|max:20', // Apenas números idealmente
            'order'     => 'nullable|integer',
        ]);

        // 2. Tratamento de Checkbox (Boolean)
        $data['is_active'] = $request->has('is_active');

        // 3. Ordem Automática (se vier vazio, vai para o fim da fila)
        if ($request->order === null) {
            $data['order'] = Consultant::max('order') + 1;
        }

        // 4. Upload da Foto (pasta 'public/consultants')
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('consultants', 'public');
        }

        Consultant::create($data);

        return redirect()->route('admin.consultants.index')
            ->with('success', 'Consultor adicionado à equipa com sucesso!');
    }

    /**
     * Mostra o formulário de edição.
     */
    public function edit(Consultant $consultant)
    {
        return view('admin.consultants.edit', compact('consultant'));
    }

    /**
     * Atualiza os dados do consultor.
     */
    public function update(Request $request, Consultant $consultant)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|max:255',
            'phone'     => 'nullable|string|max:20',
            'role'      => 'nullable|string|max:100',
            'photo'     => 'nullable|image|max:5120',
            'bio'       => 'nullable|string',
            'instagram' => 'nullable|url|max:255',
            'facebook'  => 'nullable|url|max:255',
            'linkedin'  => 'nullable|url|max:255',
            'tiktok'    => 'nullable|url|max:255',
            'whatsapp'  => 'nullable|string|max:20',
            'order'     => 'nullable|integer',
        ]);

        $data['is_active'] = $request->has('is_active');

        // Lógica de Atualização da Imagem
        if ($request->hasFile('photo')) {
            // Remove a antiga se existir e for um ficheiro local
            if ($consultant->photo && Storage::disk('public')->exists($consultant->photo)) {
                Storage::disk('public')->delete($consultant->photo);
            }
            $data['photo'] = $request->file('photo')->store('consultants', 'public');
        }

        $consultant->update($data);

        return redirect()->route('admin.consultants.index')
            ->with('success', 'Ficha do consultor atualizada!');
    }

    /**
     * Remove o consultor e a sua foto.
     */
    public function destroy(Consultant $consultant)
    {
        if ($consultant->photo && Storage::disk('public')->exists($consultant->photo)) {
            Storage::disk('public')->delete($consultant->photo);
        }
        
        $consultant->delete();

        return back()->with('success', 'Consultor removido permanentemente.');
    }
}