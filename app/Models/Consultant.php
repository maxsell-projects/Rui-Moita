<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Consultant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'photo_path',
        'bio',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'whatsapp_url',
        'is_active',
        'order',
    ];

    // Acessor para pegar a URL da foto ou uma padrão
    public function getPhotoUrlAttribute()
    {
        return $this->photo_path 
            ? Storage::url($this->photo_path) 
            : asset('images/default-avatar.png'); // Garanta que tenha uma img padrão na pasta public/images
    }
}