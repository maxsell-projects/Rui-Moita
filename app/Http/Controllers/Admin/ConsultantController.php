<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConsultantController extends Controller
{
    public function index()
    {
        $consultants = Consultant::orderBy('order')->orderBy('name')->get();
        // Atenção: Você precisará criar essa view no próximo passo
        return view('admin.consultants.index', compact('consultants'));
    }

    public function create()
    {
        return view('admin.consultants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048', // Max 2MB
            'email' => 'nullable|email',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('consultants', 'public');
        }

        Consultant::create($data);

        return redirect()->route('admin.consultants.index')->with('success', 'Consultor criado com sucesso!');
    }

    public function edit(Consultant $consultant)
    {
        return view('admin.consultants.edit', compact('consultant'));
    }

    public function update(Request $request, Consultant $consultant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Apaga a antiga se existir
            if ($consultant->photo_path) {
                Storage::disk('public')->delete($consultant->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('consultants', 'public');
        }

        $consultant->update($data);

        return redirect()->route('admin.consultants.index')->with('success', 'Consultor atualizado!');
    }

    public function destroy(Consultant $consultant)
    {
        if ($consultant->photo_path) {
            Storage::disk('public')->delete($consultant->photo_path);
        }
        $consultant->delete();

        return redirect()->route('admin.consultants.index')->with('success', 'Consultor removido.');
    }
}