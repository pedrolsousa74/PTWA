<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'artigo_id',
        'user_id',
        'conteudo',
    ];

    public function artigo()
    {
        return $this->belongsTo(Artigo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
