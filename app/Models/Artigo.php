<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artigo extends Model
{
    protected $fillable = ['titulo', 'subtitulo', 'categoria', 'conteudo', 'user_id', 'imagem'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usersWhoLiked()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class)->latest(); // ordena por created_at DESC
    }


}
