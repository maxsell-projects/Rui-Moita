<?php

namespace App\Http\Controllers;

use App\Models\AccessRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
// Certifique-se de copiar também os arquivos de Email (Mailables) do Crow para a pasta app/Mail do Rui
use App\Mail\AccessApprovedMail;
use App\Mail\AccessRejectedMail;

class AccessRequestController extends Controller
{
    /**
     * Processa o formulário público de solicitação de acesso "Off-Market"
     */
    public function store(Request $request)
    {
        // Validação dos dados vindos do formulário
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:access_requests,email', // Garante que não duplica pedidos
            'country' => 'required|string|max:255',
            'investor_type' => 'required|string', // Simplifiquei para string caso mude os tipos no front
            'investment_amount' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'proof_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Máx 5MB
            'consent' => 'required|accepted',
        ]);

        // Upload do documento (se houver)
        if ($request->hasFile('proof_document')) {
            $path = $request->file('proof_document')->store('proof_documents', 'public');
            $validated['proof_document'] = $path;
        }

        // Cria o registro no banco
        $accessRequest = AccessRequest::create($validated);

        // Notifica os administradores (Envia para o email configurado no .env)
        try {
            // Busca admins ou usa o email geral do sistema
            $admins = User::where('role', 'admin')->pluck('email')->toArray();
            if (empty($admins)) $admins = [config('mail.from.address')];

            Mail::raw("Novo Pedido de Acesso Off-Market (Rui Moita)\n\nNome: {$accessRequest->name}\nTipo: {$accessRequest->investor_type}\nEmail: {$accessRequest->email}", function ($message) use ($admins) {
                $message->to($admins)->subject('🔔 Novo Pedido de Acesso Recebido');
            });
        } catch (\Exception $e) {
            Log::error("Erro ao notificar admins: " . $e->getMessage());
        }

        // Redireciona de volta com mensagem de sucesso
        return redirect()->back()->with('success', 'O seu pedido foi recebido com sucesso! A nossa equipa irá analisar e entrar em contacto brevemente.');
    }

    /**
     * Lista todos os pedidos pendentes (Painel Admin)
     */
    public function index()
    {
        // Proteção extra (além da rota)
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        $requests = AccessRequest::with('reviewer')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Você precisará criar esta view em: resources/views/admin/access-requests.blade.php
        return view('admin.access-requests', compact('requests'));
    }

    /**
     * Mostra detalhes de um pedido específico (Painel Admin)
     */
    public function show(AccessRequest $accessRequest)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        // Você precisará criar esta view em: resources/views/admin/access-requests-show.blade.php
        return view('admin.access-requests-show', compact('accessRequest'));
    }

    /**
     * APROVAR um pedido
     */
    public function approve(Request $request, AccessRequest $accessRequest)
    {
        if (!auth()->user()->isAdmin()) abort(403);

        $validated = $request->validate([
            'access_days' => 'nullable|integer|min:1',
            'admin_notes' => 'nullable|string',
        ]);

        $days = $validated['access_days'] ?? 90; // Padrão de 90 dias se não informado
        $temporaryPassword = Str::random(12);    // Gera senha aleatória

        // Define a role do usuário baseada no tipo de investidor
        $role = ($accessRequest->investor_type === 'developer') ? 'developer' : 'client';

        // Verifica se o usuário já existe ou cria um novo
        $user = User::where('email', $accessRequest->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $accessRequest->name,
                'email' => $accessRequest->email,
                'password' => Hash::make($temporaryPassword),
                'role' => $role,
                'status' => 'active',          // Importante: Ativa o user
                'market_access' => true,       // Importante: Libera o Off-Market
                'access_expires_at' => now()->addDays($days),
            ]);
        } else {
            // Se já existe, apenas atualiza as permissões
            $user->update([
                'role' => $role,
                'status' => 'active',
                'market_access' => true,
                'access_expires_at' => now()->addDays($days),
            ]);
        }

        // Atualiza o status do pedido
        $accessRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'admin_notes' => $validated['admin_notes'] ?? null,
            'reviewed_at' => now(),
        ]);

        // Envia email de boas-vindas com a senha
        try {
            Mail::to($user->email)->send(new AccessApprovedMail($user, $temporaryPassword));
        } catch (\Exception $e) {
            Log::error("Erro ao enviar email de aprovação: " . $e->getMessage());
            return redirect()->back()->with('warning', 'Aprovado, mas o e-mail falhou. Senha temp: ' . $temporaryPassword);
        }

        return redirect()->back()->with('success', 'Acesso aprovado e credenciais enviadas!');
    }

    /**
     * REJEITAR um pedido
     */
    public function reject(Request $request, AccessRequest $accessRequest)
    {
        if (!auth()->user()->isAdmin()) abort(403);

        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $accessRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'admin_notes' => $validated['rejection_reason'],
            'reviewed_at' => now(),
        ]);

        // Envia email de rejeição
        try {
            Mail::to($accessRequest->email)->send(new AccessRejectedMail($accessRequest));
        } catch (\Exception $e) {
            Log::error("Erro ao enviar email de rejeição: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pedido rejeitado e utilizador notificado.');
    }
}