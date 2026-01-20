<?php

namespace App\Http\Controllers;

use App\Mail\RecruitmentApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class RecruitmentController extends Controller
{
    public function submit(Request $request)
    {
        // 1. Validação Robusta
        $validated = $request->validate([
            'name'     => 'required|string|min:3|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'required|string|min:9|max:20',
            'linkedin' => 'nullable|url|max:255',
            'message'  => 'nullable|string|max:2000',
            'cv'       => 'nullable|file|mimes:pdf|max:5120', // Max 5MB
        ]);

        try {
            // 2. Upload do CV (se existir)
            if ($request->hasFile('cv')) {
                $path = $request->file('cv')->store('resumes', 'private'); // Store privado por segurança
                $validated['cv_path'] = storage_path('app/private/' . $path);
            }

            // 3. Envio de Email
            // Envia para o email definido nas configs ou hardcoded como pediste
            Mail::to('info@porthouserealestate.com')->send(new RecruitmentApplication($validated));

            Log::info('Candidatura recebida: ' . $validated['email']);

            return back()->with('success', 'Candidatura enviada com sucesso! Analisaremos o seu perfil em breve.');

        } catch (\Exception $e) {
            Log::error('ERRO CRÍTICO RECRUTAMENTO: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Erro ao enviar candidatura. Por favor, tente via email direto.');
        }
    }
}