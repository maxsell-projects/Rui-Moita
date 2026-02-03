<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // 1. Criar tabela de Solicitações de Acesso (Cópia exata do Crow)
    Schema::create('access_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('country');
        // Ajuste os tipos de investidor conforme a realidade do Rui Moita, ou mantenha igual
        $table->enum('investor_type', ['client', 'developer', 'family-office', 'institutional']);
        $table->string('requested_role')->nullable();
        $table->string('investment_amount')->nullable();
        $table->text('message')->nullable();
        $table->string('proof_document')->nullable();
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
        $table->text('admin_notes')->nullable();
        $table->timestamp('reviewed_at')->nullable();
        $table->timestamps();
    });

    // 2. Alterar tabela Users para suportar controle de acesso
    Schema::table('users', function (Blueprint $table) {
        // Se a coluna role não existir, cria. Se existir, ignora.
        if (!Schema::hasColumn('users', 'role')) {
            $table->string('role')->default('client')->after('email'); // admin, client, developer
        }
        $table->string('status')->default('pending')->after('role'); // pending, active, suspended
        $table->boolean('market_access')->default(false); // Acesso ao off-market
        $table->timestamp('access_expires_at')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
