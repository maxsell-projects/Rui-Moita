<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('role')->default('Consultor Imobiliário'); // Cargo
            $table->string('photo_path')->nullable(); // Foto do perfil
            $table->text('bio')->nullable(); // Sobre o consultor
            
            // Redes Sociais
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('whatsapp_url')->nullable(); // Link direto pro whats

            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // Para ordenar na tela
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultants');
    }
};