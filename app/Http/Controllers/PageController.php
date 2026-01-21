<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Página Pública: A Nossa Equipa
     * Exibe apenas consultores marcados como 'ativos', ordenados pela preferência do admin.
     */
    public function team()
    {
        // Usa o Scope 'active' e 'ordered' que definimos no Model
        $consultants = Consultant::active()
            ->ordered()
            ->get();

        return view('team', compact('consultants'));
    }

    /**
     * Página Pública: Trabalhe Connosco (Recrutamento)
     * Exibe o formulário de candidatura.
     */
    public function recruitment()
    {
        return view('recruitment');
    }
}