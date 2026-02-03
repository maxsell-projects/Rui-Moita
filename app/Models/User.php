<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // Novos campos para o controle de acesso (Off-Market)
        'role',              // admin, client, developer
        'status',            // pending, active, suspended
        'market_access',     // boolean: tem acesso ao off-market?
        'access_expires_at', // validade do acesso
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            // Novos casts
            'market_access' => 'boolean',
            'access_expires_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods (Lógica de Acesso)
    |--------------------------------------------------------------------------
    */

    /**
     * Verifica se o utilizador é Administrador
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Verifica se o utilizador tem conta Ativa
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Lógica Central: Verifica se tem acesso ao Off-Market
     * Regra: Precisa estar ativo + ter flag true + data válida (ou nula/vitalícia)
     */
    public function hasMarketAccess(): bool
    {
        // Se for admin, tem sempre acesso
        if ($this->isAdmin()) {
            return true;
        }

        return $this->isActive() 
            && $this->market_access 
            && ($this->access_expires_at === null || $this->access_expires_at->isFuture());
    }
}