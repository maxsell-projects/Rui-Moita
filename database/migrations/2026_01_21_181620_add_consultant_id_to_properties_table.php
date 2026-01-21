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
        Schema::table('properties', function (Blueprint $table) {
            // Cria a coluna consultant_id que se liga à tabela consultants
            // nullOnDelete() significa: se apagares o consultor, o imóvel fica sem dono (null) em vez de ser apagado
            $table->foreignId('consultant_id')
                  ->nullable()
                  ->after('user_id') // Fica organizado logo a seguir ao user_id
                  ->constrained('consultants')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Remove a chave estrangeira e a coluna se precisares de reverter
            $table->dropForeign(['consultant_id']);
            $table->dropColumn('consultant_id');
        });
    }
};