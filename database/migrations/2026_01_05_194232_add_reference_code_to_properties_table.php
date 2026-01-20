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
            // Adiciona o campo logo após o ID para facilitar visualização no banco
            // nullable() é vital se já houver registros, depois você popula e remove se quiser
            // unique() garante a integridade da regra de negócio
            $table->string('reference_code', 20)
                  ->nullable()
                  ->unique()
                  ->after('id')
                  ->comment('Código de identificação visual (ex: REF-1001)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('reference_code');
        });
    }
};