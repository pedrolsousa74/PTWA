<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Artigo;

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
        'is_admin',
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
            'is_admin' => 'boolean',
        ];
    }
    
    /**
     * Verifica se o utilizador é administrador
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        // Converter para booleano explicitamente para garantir comparação correta
        return (bool)$this->is_admin === true;
    }

    public function artigos()
    {
        return $this->hasMany(Artigo::class);
    }

    public function likes()
    {
        return $this->belongsToMany(Artigo::class, 'likes')->withTimestamps();
    }

    public function artigosFavoritos()
    {
        return $this->belongsToMany(Artigo::class, 'likes')->withTimestamps();
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }




}
