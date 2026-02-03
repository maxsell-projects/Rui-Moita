<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Mail; // Adicionado
use Illuminate\Support\Facades\Log;  // Adicionado

class DeveloperController extends Controller
{
    public function index()
    {
        $clients = Auth::user()->clients()->orderBy('created_at', 'desc')->paginate(10);
        return view('developer.clients', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $tempPassword = Str::random(10);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($tempPassword),
            'role' => 'client',
            'status' => 'pending', 
            'developer_id' => Auth::id(),
            'email_verified_at' => now(),
            'can_view_all_properties' => false,
        ]);

        // --- ALTERAÇÃO: Notificar Admin para aprovação ---
        try {
            $admins = User::where('role', 'admin')->pluck('email')->toArray();
            if (empty($admins)) $admins = ['admin@crow-global.com'];

            Mail::raw("Novo Cliente pré-cadastrado por Developer!\n\nDeveloper: " . Auth::user()->name . "\nCliente: {$validated['name']}\nEmail: {$validated['email']}\n\nAcesse o painel 'Exclusive Requests' (Wallets) para aprovar.", function ($m) use ($admins) {
                $m->to($admins)->subject('🔔 Validação de Carteira Exclusiva Necessária');
            });
        } catch (\Exception $e) {
            Log::error("Erro ao notificar admin sobre cliente do dev: " . $e->getMessage());
        }
        // ------------------------------------------------

        return redirect()->back()->with('success', "Pré-cadastro realizado! O Admin foi notificado. Senha: {$tempPassword}");
    }

    public function toggleClientStatus(User $client)
    {
        if ($client->developer_id !== Auth::id()) abort(403);

        if ($client->status === 'pending') {
            return redirect()->back()->with('error', 'Aguarde aprovação do Admin.');
        }

        $newStatus = $client->status === 'active' ? 'inactive' : 'active';
        $client->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status atualizado.');
    }

    public function toggleMarketAccess(User $client)
    {
        if ($client->developer_id !== Auth::id()) abort(403);

        // Só permite liberar mercado se estiver ativo (aprovado pelo admin)
        if ($client->status !== 'active') {
            return redirect()->back()->with('error', 'O cliente precisa estar Ativo para receber acesso ao mercado.');
        }

        $client->can_view_all_properties = !$client->can_view_all_properties;
        $client->save();

        $status = $client->can_view_all_properties ? 'Mercado Aberto' : 'Carteira Fechada';
        return redirect()->back()->with('success', "Visibilidade alterada para: {$status}");
    }

    public function resetClientPassword(User $client)
    {
        if ($client->developer_id !== Auth::id()) abort(403);

        $newPassword = Str::random(10);
        $client->update(['password' => Hash::make($newPassword)]);

        return redirect()->back()->with('success', "Senha resetada com sucesso! Nova senha: {$newPassword}");
    }

    public function destroy(User $client)
    {
        if ($client->developer_id !== Auth::id()) abort(403);
        $client->delete();
        return redirect()->back()->with('success', 'Cliente removido.');
    }

    public function toggleAccess(Request $request, Property $property)
    {
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) abort(403);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'access' => 'required|boolean'
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->developer_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($user->status !== 'active') {
            return response()->json(['message' => 'Cliente inativo ou pendente.'], 403);
        }

        if ($request->boolean('access')) {
            $property->allowedUsers()->syncWithoutDetaching([
                $request->user_id => ['granted_by' => Auth::id()]
            ]);
            $message = 'Acesso concedido.';
        } else {
            $property->allowedUsers()->detach($request->user_id);
            $message = 'Acesso revogado.';
        }

        return response()->json(['message' => $message]);
    }
}