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
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (CORRIGIDO)
|--------------------------------------------------------------------------
*/

// 1. Home & Institucional (Público)
Route::get('/', [PageController::class, 'home'])->name('home');

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

// Páginas Estáticas
Route::controller(PageController::class)->group(function () {
    Route::get('/about', 'about')->name('pages.about');
    Route::get('/services', 'services')->name('pages.services');
    Route::get('/sell-with-us', 'sell')->name('pages.sell');
    Route::get('/contact', 'contact')->name('pages.contact');
    Route::get('/simulators', 'simulators')->name('pages.simulators');
});

// Ferramentas & Simuladores
Route::controller(ToolsController::class)->group(function () {
    Route::get('/simulators/capital-gains', 'showGainsSimulator')->name('tools.gains');
    Route::post('/simulators/capital-gains/calculate', 'calculateGains')->name('tools.gains.calculate');
    Route::get('/simulators/credit', 'showCreditSimulator')->name('tools.credit');
    Route::post('/simulators/credit/send', 'sendCreditSimulation')->name('tools.credit.send');
    Route::get('/simulators/imt', 'showImtSimulator')->name('tools.imt');
    Route::post('/simulators/imt/send', 'sendImtSimulation')->name('tools.imt.send');
    Route::post('/contact/send', 'sendContact')->name('contact.send');
});

// Imóveis (Listagem Pública)
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');

// Formulários Públicos (Lead Generation)
// NOTA: Definimos estas rotas específicas ANTES da rota genérica 'show'
Route::post('/properties/{property}/visit', [PropertyController::class, 'sendVisitRequest'])->name('properties.visit');
Route::post('/properties/{property}/contact', [PropertyController::class, 'sendContact'])->name('properties.contact');
Route::post('/access-request', [AccessRequestController::class, 'store'])->name('access-request.store');

// Legal
Route::controller(LegalController::class)->group(function () {
    Route::get('/privacy-policy', 'privacy')->name('legal.privacy');
    Route::get('/terms-of-service', 'terms')->name('legal.terms');
    Route::get('/cookies-policy', 'cookies')->name('legal.cookies');
    Route::get('/legal-notice', 'notice')->name('legal.notice');
});

// 2. Área Autenticada
Route::middleware(['auth', 'active_access'])->group(function () {
    
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        
        $exclusiveProperties = collect([]);
        if ($user->role === 'client' || $user->role === 'developer') {
            $exclusiveProperties = App\Models\Property::where('is_exclusive', true)
                                         ->where('status', 'active')
                                         ->limit(3)
                                         ->get(); 
        }
        return view('dashboard', compact('exclusiveProperties'));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestão de Imóveis (Developer & Admin)
    Route::middleware('can:manageProperties,App\Models\User')->group(function () {
        // ROTAS ESPECÍFICAS PRIMEIRO
        Route::get('/my-properties', [PropertyController::class, 'myProperties'])->name('properties.my');
        Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create'); // <--- AQUI ESTAVA O CONFLITO
        Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
        
        Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::patch('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

        Route::get('/my-clients', [DeveloperController::class, 'index'])->name('developer.clients');
        Route::post('/my-clients', [DeveloperController::class, 'store'])->name('developer.clients.store');
        Route::patch('/my-clients/{client}/toggle', [DeveloperController::class, 'toggleClientStatus'])->name('developer.clients.toggle');
        Route::patch('/my-clients/{client}/toggle-market', [DeveloperController::class, 'toggleMarketAccess'])->name('developer.clients.toggle-market');
        Route::patch('/my-clients/{client}/reset-password', [DeveloperController::class, 'resetClientPassword'])->name('developer.clients.reset-password');
        Route::delete('/my-clients/{client}', [DeveloperController::class, 'destroy'])->name('developer.clients.destroy');
        
        Route::get('/properties/{property}/access-list', [PropertyController::class, 'getAccessList'])->name('properties.access-list');
        Route::post('/properties/{property}/access', [DeveloperController::class, 'toggleAccess'])->name('properties.access');
    });

    // ADMIN
    Route::middleware('can:isAdmin,App\Models\User')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/access-requests', [AccessRequestController::class, 'index'])->name('access-requests');
        Route::get('/access-requests/{accessRequest}', [AccessRequestController::class, 'show'])->name('access-requests.show');
        Route::patch('/access-requests/{accessRequest}/approve', [AccessRequestController::class, 'approve'])->name('access-requests.approve');
        Route::patch('/access-requests/{accessRequest}/reject', [AccessRequestController::class, 'reject'])->name('access-requests.reject');
        
        Route::get('/exclusive-requests', [AdminController::class, 'exclusiveRequests'])->name('exclusive-requests');
        Route::patch('/exclusive-requests/{user}/approve', [AdminController::class, 'approveExclusiveRequest'])->name('exclusive-requests.approve');
        Route::delete('/exclusive-requests/{user}/reject', [AdminController::class, 'rejectExclusiveRequest'])->name('exclusive-requests.reject');

        Route::get('/properties/pending', [AdminController::class, 'pendingProperties'])->name('properties.pending');
        Route::patch('/properties/{property}/approve-listing', [PropertyController::class, 'approve'])->name('properties.approve-listing');
        Route::patch('/properties/{property}/reject-listing', [PropertyController::class, 'reject'])->name('properties.reject-listing');

        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::patch('/users/{user}/reset-password', [AdminController::class, 'resetUserPassword'])->name('users.reset-password');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        Route::get('/properties', [AdminController::class, 'properties'])->name('properties');
        Route::delete('/properties/{property}', [AdminController::class, 'deleteProperty'])->name('properties.destroy');
    });
});

// 3. Rota Genérica (WILDCARD) - SEMPRE NO FINAL
// Se colocarmos antes, ela "engole" a rota /properties/create achando que 'create' é um ID.
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

require __DIR__.'/auth.php';