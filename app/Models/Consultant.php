<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Consultant extends Model
{
    use HasFactory;

    /**
     * Campos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'phone',
        'photo',
        'bio',
        'order',
        'is_active',
        // Redes Sociais
        'instagram',
        'facebook',
        'linkedin',
        'tiktok',
        'whatsapp',
    ];

    /**
     * Conversão automática de tipos.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * Acessor Inteligente para a Foto (photo_url).
     * Uso na Blade: <img src="{{ $consultant->photo_url }}">
     */
    public function getPhotoUrlAttribute()
    {
        // 1. Se não houver foto definida, retorna um avatar gerado com as iniciais (UI Avatars)
        if (!$this->photo) {
            $name = urlencode($this->name);
            // Cores da marca: Fundo escuro (Brand Secondary) e texto Dourado (Brand Accent)
            return "https://ui-avatars.com/api/?name={$name}&color=C5A572&background=1B2A2F&size=512";
        }

        // 2. Se for uma URL completa (ex: link externo), retorna a própria URL
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }

        // 3. Verifica se o ficheiro existe no Storage (Uploads)
        if (Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
        }

        // 4. Fallback para imagens estáticas na pasta public/img (caso uses seeders antigos)
        if (file_exists(public_path($this->photo))) {
            return asset($this->photo);
        }
        
        // 5. Último recurso: Avatar genérico
        return "https://ui-avatars.com/api/?name=User&color=7F9CF5&background=EBF4FF";
    }

    /**
     * Scope para ordenar consultores facilmente.
     * Uso: Consultant::ordered()->get();
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Scope para pegar apenas ativos.
     * Uso: Consultant::active()->ordered()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}