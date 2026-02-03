<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['apartment', 'house', 'villa', 'land', 'commercial', 'office']);
            $table->enum('transaction_type', ['sale', 'rent']);
            $table->enum('condition', ['new', 'used', 'renovated', 'under_construction'])->nullable();
            $table->decimal('price', 15, 2);
            $table->string('city');
            $table->string('district')->nullable();
            $table->string('address');
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('area')->nullable();
            $table->integer('land_area')->nullable();
            $table->integer('year_built')->nullable();
            $table->string('energy_rating')->nullable();
            $table->string('video_url')->nullable();
            $table->string('whatsapp')->nullable();
            $table->json('features')->nullable();
            $table->json('images')->nullable();
            $table->enum('status', ['draft', 'pending', 'published', 'sold', 'rented'])->default('draft');
            $table->boolean('is_exclusive')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};