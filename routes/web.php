<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\AccessRequestController;
use App\Http\Controllers\Admin\ConsultantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Rui Moita + Crow Core)
|--------------------------------------------------------------------------
*/

// --- 1. PÚBLICO & INSTITUCIONAL ---

Route::get('/', [PageController::class, 'home'])->name('home');

// Páginas Institucionais (Rui Moita)
Route::controller(PageController::class)->group(function () {
    Route::get('/sobre', 'about')->name('about');
    Route::get('/equipa', 'team')->name('team');
    Route::get('/recrutamento', 'recruitment')->name('recruitment');
    Route::get('/servicos', 'services')->name('services');
    Route::get('/vender', 'sell')->name('sell');
    Route::get('/contactos', 'contact')->name('contact');
    Route::get('/simuladores', 'simulators')->name('simulators');
});

// Imóveis (Listagem Pública - Lógica Crow)
Route::get('/imoveis', [PropertyController::class, 'index'])->name('properties.index');

// Ferramentas & Simuladores
Route::controller(ToolsController::class)->group(function () {
    Route::get('/simuladores/mais-valias', 'showGainsSimulator')->name('tools.gains');
    Route::post('/simuladores/mais-valias/calcular', 'calculateGains')->name('tools.gains.calculate');
    Route::get('/simuladores/credito', 'showCreditSimulator')->name('tools.credit');
    Route::post('/simuladores/credito/enviar', 'sendCreditSimulation')->name('tools.credit.send');
    Route::get('/simuladores/imt', 'showImtSimulator')->name('tools.imt');
    Route::post('/simuladores/imt/enviar', 'sendImtSimulation')->name('tools.imt.send');
    
    // Envio de Contacto Geral
    Route::post('/contact/send', 'sendContact')->name('contact.send');
});

// Chatbot AI
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])
    ->name('chatbot.send')
    ->middleware(['web']);

// Troca de idioma
Route::get('language/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'pt', 'fr'])) abort(400);
    session(['locale' => $locale]);
    return redirect()->back()->withCookie(cookie('crow_locale', $locale, 525600));
})->name('language.switch');

// Legal (CORRIGIDO: Nomes simplificados para 'privacy' e 'terms')
Route::controller(LegalController::class)->group(function () {
    Route::get('/politica-privacidade', 'privacy')->name('privacy'); // Era 'legal.privacy'
    Route::get('/termos-servico', 'terms')->name('terms');         // Era 'legal.terms'
    Route::get('/politica-cookies', 'cookies')->name('cookies');   // Era 'legal.cookies'
    Route::get('/aviso-legal', 'notice')->name('legal.notice');
});

// Formulários de Lead (Imóveis)
Route::post('/imoveis/{property}/visit', [PropertyController::class, 'sendVisitRequest'])->name('properties.visit');
Route::post('/imoveis/{property}/contact', [PropertyController::class, 'sendContact'])->name('properties.contact');
Route::post('/access-request', [AccessRequestController::class, 'store'])->name('access-request.store');


// --- 2. ÁREA AUTENTICADA (DASHBOARD) ---

Route::middleware(['auth', 'active_access'])->group(function () {
    
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        
        // Lógica para mostrar imóveis exclusivos no dashboard do cliente
        $exclusiveProperties = collect([]);
        if ($user->role === 'client' || $user->role === 'developer') {
            $exclusiveProperties = App\Models\Property::where('is_exclusive', true)
                                                     ->where('status', 'active')
                                                     ->limit(3)
                                                     ->get(); 
        }
        return view('dashboard', compact('exclusiveProperties'));
    })->name('dashboard');

    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestão de Imóveis (Developer & Admin)
    Route::middleware('can:manageProperties,App\Models\User')->group(function () {
        // ROTAS ESPECÍFICAS PRIMEIRO
        Route::get('/meus-imoveis', [PropertyController::class, 'myProperties'])->name('properties.my');
        Route::get('/imoveis/criar', [PropertyController::class, 'create'])->name('properties.create');
        Route::post('/imoveis', [PropertyController::class, 'store'])->name('properties.store');
        
        Route::get('/imoveis/{property}/editar', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::patch('/imoveis/{property}', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/imoveis/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

        // Gestão de Clientes (Developer)
        Route::get('/meus-clientes', [DeveloperController::class, 'index'])->name('developer.clients');
        Route::post('/meus-clientes', [DeveloperController::class, 'store'])->name('developer.clients.store');
        Route::patch('/meus-clientes/{client}/toggle', [DeveloperController::class, 'toggleClientStatus'])->name('developer.clients.toggle');
        Route::patch('/meus-clientes/{client}/toggle-market', [DeveloperController::class, 'toggleMarketAccess'])->name('developer.clients.toggle-market');
        Route::patch('/meus-clientes/{client}/reset-password', [DeveloperController::class, 'resetClientPassword'])->name('developer.clients.reset-password');
        Route::delete('/meus-clientes/{client}', [DeveloperController::class, 'destroy'])->name('developer.clients.destroy');
        
        Route::get('/imoveis/{property}/access-list', [PropertyController::class, 'getAccessList'])->name('properties.access-list');
        Route::post('/imoveis/{property}/access', [DeveloperController::class, 'toggleAccess'])->name('properties.access');
    });

    // --- 3. ADMIN PANEL ---
    Route::middleware('can:isAdmin,App\Models\User')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Consultores (Novo!)
        Route::resource('consultants', ConsultantController::class);

        // Requests de Acesso
        Route::get('/access-requests', [AccessRequestController::class, 'index'])->name('access-requests');
        Route::get('/access-requests/{accessRequest}', [AccessRequestController::class, 'show'])->name('access-requests.show');
        Route::patch('/access-requests/{accessRequest}/approve', [AccessRequestController::class, 'approve'])->name('access-requests.approve');
        Route::patch('/access-requests/{accessRequest}/reject', [AccessRequestController::class, 'reject'])->name('access-requests.reject');
        
        // Requests de Exclusividade
        Route::get('/exclusive-requests', [AdminController::class, 'exclusiveRequests'])->name('exclusive-requests');
        Route::patch('/exclusive-requests/{user}/approve', [AdminController::class, 'approveExclusiveRequest'])->name('exclusive-requests.approve');
        Route::delete('/exclusive-requests/{user}/reject', [AdminController::class, 'rejectExclusiveRequest'])->name('exclusive-requests.reject');

        // Aprovação de Imóveis
        Route::get('/properties/pending', [AdminController::class, 'pendingProperties'])->name('properties.pending');
        Route::patch('/properties/{property}/approve-listing', [PropertyController::class, 'approve'])->name('properties.approve-listing');
        Route::patch('/properties/{property}/reject-listing', [PropertyController::class, 'reject'])->name('properties.reject-listing');

        // Gestão de Usuários
        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::patch('/users/{user}/reset-password', [AdminController::class, 'resetUserPassword'])->name('users.reset-password');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        // Gestão Global de Imóveis
        Route::get('/properties', [AdminController::class, 'properties'])->name('properties');
        Route::delete('/properties/{property}', [AdminController::class, 'deleteProperty'])->name('properties.destroy');
    });
});

// 4. Rota Genérica (WILDCARD) - SEMPRE NO FINAL
// Isso captura /imoveis/123-slug-do-imovel
Route::get('/imoveis/{property}', [PropertyController::class, 'show'])->name('properties.show');

require __DIR__.'/auth.php';