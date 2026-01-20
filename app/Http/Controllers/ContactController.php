<?php

namespace App\Http\Controllers;

use App\Mail\ContactLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Log para auditoria de tráfego
        Log::info('Lead recebida.', ['ip' => $request->ip()]);

        // Validação estrita conforme SOP 3.5
        $validated = $request->validate([
            'name'          => 'required|string|min:3|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|min:9|max:20', // Obrigatório conforme SOP
            'location'      => 'nullable|string|max:255',
            'typology'      => 'nullable|string|max:50',
            'goal'          => 'required|string', // Venda, Compra, Investimento
            'timeline'      => 'required|string', // 0, 3, 6, +6 meses
            'sell_to_buy'   => 'required|string', // Sim/Não
            'privacy_check' => 'required|accepted', // Checkbox obrigatória
            'message'       => 'nullable|string|max:2000', // Opcional, pois os campos acima já filtram
        ]);

        try {
            // Envio de Email (Podes manter a Mailable atual, só garante que ela recebe o array $validated)
            Mail::to(config('mail.from.address'))->send(new ContactLead($validated));

            return back()->with('success', 'Pedido recebido com sucesso. Entraremos em contacto brevemente.');
        } catch (\Exception $e) {
            Log::error('ERRO CRÍTICO NO ENVIO DE LEAD: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Erro ao enviar. Por favor, tente via WhatsApp.');
        }
    }
}