<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminConsultantController extends Controller
{
    /**
     * Exibe a lista de consultores.
     */
    public function index()
    {
        // A proteção de 'auth' e 'admin' será feita via rotas/middleware
        $consultants = Consultant::latest()->paginate(10);
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
     * Salva o novo consultor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bio' => 'nullable|string',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('consultants', 'public');
            $validated['photo'] = $path;
        }

        Consultant::create($validated);

        return redirect()->route('admin.consultants.index')
            ->with('success', 'Consultor adicionado com sucesso!');
    }

    /**
     * Mostra o formulário de edição.
     */
    public function edit(Consultant $consultant)
    {
        return view('admin.consultants.edit', compact('consultant'));
    }

    /**
     * Atualiza o consultor.
     */
    public function update(Request $request, Consultant $consultant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Foto opcional na edição
            'bio' => 'nullable|string',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        if ($request->hasFile('photo')) {
            // Apaga a foto antiga se existir
            if ($consultant->photo) {
                Storage::disk('public')->delete($consultant->photo);
            }
            $path = $request->file('photo')->store('consultants', 'public');
            $validated['photo'] = $path;
        }

        $consultant->update($validated);

        return redirect()->route('admin.consultants.index')
            ->with('success', 'Consultor atualizado com sucesso!');
    }

    /**
     * Remove o consultor.
     */
    public function destroy(Consultant $consultant)
    {
        if ($consultant->photo) {
            Storage::disk('public')->delete($consultant->photo);
        }
        
        $consultant->delete();

        return redirect()->route('admin.consultants.index')
            ->with('success', 'Consultor removido.');
    }
}