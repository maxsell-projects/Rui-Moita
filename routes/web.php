<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Controllers do Rui Moita (Funcionalidades Específicas)
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminConsultantController; // Controller adaptado

// Controllers da Crow (Auth, Dashboard e Acessos)
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccessRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes - José Carvalho Real Estate
|--------------------------------------------------------------------------
*/

// ========================================================================
// 1. ÁREA PÚBLICA (FRONT-END RUI MOITA)
// ========================================================================

// Troca de Idioma
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['pt', 'en', 'fr'])) {
        Session::put('locale', $locale);
    }
    return back();
})->name('lang.switch');

// Home Page
Route::get('/', function () {
    $properties = \App\Models\Property::where('is_visible', true)
        ->where('is_featured', true)
        ->latest()
        ->take(3)
        ->get();
    return view('home', compact('properties'));
})->name('home');

// Páginas Institucionais
Route::get('/sobre', function () { return view('about'); })->name('about');
Route::get('/equipa', [PageController::class, 'team'])->name('team');

// Contactos & Leads
Route::get('/contactos', function () { return view('contact'); })->name('contact');
Route::post('/contactos/enviar', [ContactController::class, 'send'])->name('contact.send');

// Off-Market (Formulário Público de Solicitação)
Route::post('/access-request', [AccessRequestController::class, 'store'])->name('access-request.store');

// Recrutamento
Route::get('/recrutamento', [PageController::class, 'recruitment'])->name('recruitment');
Route::post('/recrutamento/enviar', [RecruitmentController::class, 'submit'])->name('recruitment.submit');

// Portfólio de Imóveis (Público)
Route::get('/imoveis', [PropertyController::class, 'publicIndex'])->name('portfolio');
Route::get('/imoveis/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');

// Ferramentas (Simuladores)
Route::get('/ferramentas/simulador-credito', function () { return view('tools.credit'); })->name('tools.credit');
Route::get('/ferramentas/imt', function () { return view('tools.imt'); })->name('tools.imt');
Route::get('/ferramentas/mais-valias', [ToolsController::class, 'showGainsSimulator'])->name('tools.gains');
Route::post('/ferramentas/mais-valias/calcular', [ToolsController::class, 'calculateGains'])->name('tools.gains.calculate');

// Legal & Chatbot
Route::get('/termos-e-condicoes', function () { return view('legal.terms'); })->name('terms');
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');


// ========================================================================
// 2. ÁREA PRIVADA / BACKOFFICE (SISTEMA CROW + CONSULTORES)
// ========================================================================

// Grupo protegido por Login (auth) e Validação de Acesso (active_access)
Route::middleware(['auth', 'active_access'])->group(function () {

    // --- Perfil do Utilizador ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Área Admin (Prefixo /admin) ---
    Route::prefix('admin')->group(function () {
        
        // Dashboard Principal (Visualização Geral)
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Gestão de Imóveis (CRUD)
        Route::resource('properties', PropertyController::class)->names('admin.properties');

        // --- Funcionalidades Exclusivas de ADMIN (Middleware 'admin') ---
        Route::middleware(['admin'])->group(function () {
            
            // 1. Gestão de Acessos Off-Market (Crow Logic)
            Route::get('/access-requests', [AccessRequestController::class, 'index'])->name('admin.access-requests');
            Route::get('/access-requests/{accessRequest}', [AccessRequestController::class, 'show'])->name('admin.access-requests.show');
            Route::patch('/access-requests/{accessRequest}/approve', [AccessRequestController::class, 'approve'])->name('admin.access-requests.approve');
            Route::patch('/access-requests/{accessRequest}/reject', [AccessRequestController::class, 'reject'])->name('admin.access-requests.reject');

            // 2. Gestão de Equipa / Consultores (Rui Moita Logic)
            // Adaptado para rodar dentro da segurança da Crow
            Route::resource('consultants', AdminConsultantController::class)->names('admin.consultants');
        });
    });
});

// ========================================================================
// 3. ROTAS DE AUTENTICAÇÃO (SISTEMA CROW)
// ========================================================================
// Certifique-se de ter copiado o arquivo 'routes/auth.php' da Crow para o Rui
require __DIR__.'/auth.php';