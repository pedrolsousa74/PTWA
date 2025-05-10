<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artigo extends Model
{
    protected $fillable = ['titulo', 'subtitulo', 'categoria', 'conteudo', 'user_id'];
}
