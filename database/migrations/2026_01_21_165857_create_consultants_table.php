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
        Schema::create('consultants', function (Blueprint $table) {
            $table->id();
            
            // Dados Principais
            $table->string('name');
            $table->string('role')->default('Consultor Imobiliário');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable(); // Caminho da imagem no Storage
            $table->text('bio')->nullable();
            
            // Gestão e Ordenação
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);

            // Redes Sociais
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('whatsapp')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultants');
    }
};