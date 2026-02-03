<?php

namespace App\Http\Controllers;

use App\Models\AccessRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccessApprovedMail;
use App\Mail\AccessRejectedMail;
use Illuminate\Support\Facades\Log;

class AccessRequestController extends Controller
{
    /**
     * Store a new access request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:access_requests,email',
            'country' => 'required|string|max:255',
            'investor_type' => 'required|in:client,developer,family-office,institutional',
            'investment_amount' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'proof_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'consent' => 'required|accepted',
        ]);

        if ($request->hasFile('proof_document')) {
            $path = $request->file('proof_document')->store('proof_documents', 'public');
            $validated['proof_document'] = $path;
        }

        $accessRequest = AccessRequest::create($validated);

        try {
            $admins = User::where('role', 'admin')->pluck('email')->toArray();
            if (empty($admins)) $admins = [config('mail.from.address')];

            Mail::raw("Novo Pedido de Acesso Off-Market (Crow Global)\n\nNome: {$accessRequest->name}\nTipo: {$accessRequest->investor_type}\nEmail: {$accessRequest->email}", function ($message) use ($admins) {
                $message->to($admins)->subject('🔔 Novo Pedido de Acesso Recebido');
            });
        } catch (\Exception $e) {
            Log::error("Erro ao notificar admins: " . $e->getMessage());
        }

        return redirect()->route('home')->with('success', 'Your application has been submitted successfully! Our team will review it and contact you shortly.');
    }

    /**
     * Show all pending access requests (admin only)
     */
    public function index()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) abort(403);

        $requests = AccessRequest::with('reviewer')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // CORREÇÃO: Aponta para o arquivo resources/views/admin/access-requests.blade.php
        return view('admin.access-requests', compact('requests'));
    }

    /**
     * Show a specific access request details (admin only)
     * MÉTODO NOVO QUE FALTAVA
     */
    public function show(AccessRequest $accessRequest)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) abort(403);

        // CORREÇÃO: Aponta para resources/views/admin/access-requests-show.blade.php
        return view('admin.access-requests-show', compact('accessRequest'));
    }

    /**
     * Approve an access request
     */
    public function approve(Request $request, AccessRequest $accessRequest)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        // CORREÇÃO: Removemos o 'required' do access_days e validamos apenas se vier
        $validated = $request->validate([
            'access_days' => 'nullable|integer|min:1',
            'admin_notes' => 'nullable|string',
        ]);

        // Define o padrão de 90 dias se não vier nada do formulário
        $days = $validated['access_days'] ?? 90;

        // Determine role based on investor type
        $role = match($accessRequest->investor_type) {
            'developer' => 'developer',
            default => 'client',
        };

        $temporaryPassword = Str::random(12);

        // Create or Update user account
        $user = User::where('email', $accessRequest->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $accessRequest->name,
                'email' => $accessRequest->email,
                'password' => Hash::make($temporaryPassword),
                'role' => $role,
                'status' => 'active',
                'market_access' => true,
                'access_expires_at' => now()->addDays($days), // Usa a variável $days com fallback
            ]);
        } else {
            $user->update([
                'role' => $role,
                'status' => 'active',
                'market_access' => true,
                'access_expires_at' => now()->addDays($days),
            ]);
        }

        $accessRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'admin_notes' => $validated['admin_notes'] ?? null,
            'reviewed_at' => now(),
        ]);

        // Send approval email
        try {
            Mail::to($user->email)->send(new AccessApprovedMail($user, $temporaryPassword));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erro ao enviar email de aprovação: " . $e->getMessage());
            return redirect()->back()->with('warning', 'Aprovado, mas o e-mail falhou. Senha temp: ' . $temporaryPassword);
        }

        return redirect()->back()->with('success', 'Access request approved successfully! Credentials sent to user.');
    }

    /**
     * Reject an access request
     */
  public function reject(Request $request, AccessRequest $accessRequest)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        // CORREÇÃO: Validamos 'rejection_reason' (nome do input no HTML)
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $accessRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            // Mapeamos o input 'rejection_reason' para a coluna 'admin_notes' do banco
            'admin_notes' => $validated['rejection_reason'],
            'reviewed_at' => now(),
        ]);

        // Send rejection email
        try {
            Mail::to($accessRequest->email)->send(new AccessRejectedMail($accessRequest));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erro ao enviar email de rejeição: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Access request rejected and user notified.');
    }
}