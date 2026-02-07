<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentRequest;
use App\Mail\RecruitmentSubmitted;
use App\Models\Consultant;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Exibe a página inicial com os imóveis mais recentes.
     */
    public function home(): View
    {
        $properties = Property::latest()->take(6)->get();

        return view('pages.home', compact('properties'));
    }

    /**
     * Exibe a página "Sobre Nós".
     */
    public function about(): View
    {
        return view('pages.about');
    }
    
    /**
     * Exibe a página da equipa com consultores ativos.
     */
    public function team(): View
    {
        $consultants = Consultant::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('pages.team', compact('consultants'));
    }

    /**
     * Exibe a página de recrutamento.
     */
    public function recruitment(): View
    {
        return view('pages.recruitment');
    }

    /**
     * Processa o envio da candidatura e dispara o e-mail para o RH.
     */
    public function submitRecruitment(RecruitmentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        // Prepara os dados para o Mailable, incluindo o objeto do ficheiro para o anexo
        $validated['cv'] = $request->file('cv');

        // Dispara o e-mail para o administrador/RH
        // Nota: Recomenda-se mover o e-mail para o .env futuramente
        Mail::to('geral@ruimoita.pt')->send(new RecruitmentSubmitted($validated));

        return back()->with('success', __('Candidatura submetida com sucesso!'));
    }

    /**
     * Exibe a página de serviços.
     */
    public function services(): View
    {
        return view('pages.services');
    }

    /**
     * Exibe a página de venda de imóveis.
     */
    public function sell(): View
    {
        return view('pages.sell');
    }

    /**
     * Exibe a página de simuladores.
     */
    public function simulators(): View
    {
        return view('pages.simulators');
    }

    /**
     * Exibe a página de contactos.
     */
    public function contact(): View
    {
        return view('pages.contact');
    }
}