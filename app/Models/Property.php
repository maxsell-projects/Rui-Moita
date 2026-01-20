<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',       // Necessário para a importação via CLI
        'reference_code', 
        'title', 
        'slug', 
        'description', 
        'type', 
        'status',
        'location', 
        'address', 
        'postal_code', 
        'city', 
        'latitude', 
        'longitude',
        'price', 
        'area_gross', 
        'area_useful', 
        'area_land',
        'bedrooms', 
        'bathrooms', 
        'garages', 
        'floor', 
        'orientation', 
        'built_year', 
        'condition', 
        'energy_rating',
        'has_lift', 
        'has_garden', 
        'has_pool', 
        'has_terrace', 
        'has_balcony', 
        'has_air_conditioning', 
        'has_heating', 
        'is_accessible', 
        'is_furnished', 
        'is_kitchen_equipped',
        'cover_image', 
        'video_url', 
        'whatsapp_number',
        'is_featured', 
        'is_visible',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area_gross' => 'decimal:2',
        'area_useful' => 'decimal:2', 
        'area_land' => 'decimal:2',   
        
        // Booleanos - Garante retorno true/false em vez de 1/0
        'has_pool' => 'boolean',
        'has_garden' => 'boolean',
        'has_lift' => 'boolean',
        'has_terrace' => 'boolean',
        'has_balcony' => 'boolean',
        'has_air_conditioning' => 'boolean',
        'has_heating' => 'boolean',
        'is_accessible' => 'boolean',
        'is_furnished' => 'boolean',
        'is_kitchen_equipped' => 'boolean',
        'is_featured' => 'boolean',
        'is_visible' => 'boolean',
    ];

    /**
     * Relacionamento com a galeria de imagens
     */
    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    /**
     * Relacionamento com o Usuário (Dono/Consultor)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}