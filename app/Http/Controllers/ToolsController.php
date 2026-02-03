<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CapitalGainsCalculatorService;
// use App\Services\HighLevelService; // Descomente quando tiver o arquivo real
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ToolsController extends Controller
{
    protected $calculator;
    // protected $crmService;

    public function __construct(CapitalGainsCalculatorService $calculator)
    {
        $this->calculator = $calculator;
        // $this->crmService = $crmService; // Injete quando tiver o Service real
    }

    public function showGainsSimulator() { return view('tools.gains'); }
     public function showCreditSimulator() { return view('tools.credit'); } // Futuro
     public function showImtSimulator() { return view('tools.imt'); } // Futuro

    public function calculateGains(Request $request)
    {
        $validated = $request->validate([
            'acquisition_value' => 'required|numeric|min:0',
            'acquisition_year' => 'required|integer|min:1900|max:2025',
            'acquisition_month' => 'required|string',
            'sale_value' => 'required|numeric|min:0',
            'sale_year' => 'required|integer|min:1900|max:2025',
            'sale_month' => 'required|string',
            'has_expenses' => 'required|string|in:Sim,Não',
            'expenses_works' => 'nullable|numeric|min:0',
            'expenses_imt' => 'nullable|numeric|min:0',
            'expenses_commission' => 'nullable|numeric|min:0',
            'expenses_other' => 'nullable|numeric|min:0',
            'sold_to_state' => 'required|string|in:Sim,Não',
            'hpp_status' => 'required_unless:sold_to_state,Sim|nullable|string',
            'retired_status' => 'required_unless:sold_to_state,Sim|nullable|string|in:Sim,Não',
            'self_built' => 'required_unless:sold_to_state,Sim|nullable|string|in:Sim,Não',
            'reinvest_intention' => 'required_unless:sold_to_state,Sim|nullable|string|in:Sim,Não',
            'reinvestment_amount' => 'nullable|numeric|min:0',
            'amortize_credit' => 'required_unless:sold_to_state,Sim|nullable|string|in:Sim,Não',
            'amortization_amount' => 'nullable|numeric|min:0',
            'joint_tax_return' => 'required_unless:sold_to_state,Sim|nullable|string|in:Sim,Não',
            'annual_income' => 'required_unless:sold_to_state,Sim|nullable|numeric|min:0',
            'public_support' => 'required_unless:sold_to_state,Sim|nullable|string|in:Sim,Não',
            'public_support_year' => 'nullable|integer',
            'public_support_month' => 'nullable|string',
            'lead_name' => 'required|string|max:255',
            'lead_email' => 'required|email|max:255'
        ]);

        $totalExpenses = 0.0;
        if ($validated['has_expenses'] === 'Sim') {
            $totalExpenses = (float) ($validated['expenses_works'] ?? 0) + 
                             (float) ($validated['expenses_imt'] ?? 0) + 
                             (float) ($validated['expenses_commission'] ?? 0) + 
                             (float) ($validated['expenses_other'] ?? 0);
        }
        $validated['expenses_total'] = $totalExpenses;

        // Chama o Service que criámos antes
        $results = $this->calculator->calculate($validated);

        // Lógica de Email e CRM (Comentada para não quebrar sem as configurações)
        /*
        if ($request->filled('lead_email')) {
            // $this->sendEmailWithPdf(...)
            // $this->sendToCrm(...)
        }
        */

        return response()->json($results);
    }
}