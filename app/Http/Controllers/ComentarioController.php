<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artigo;


class ComentarioController extends Controller
{
    public function store(Request $request, Artigo $artigo)
    {
        $request->validate([
            'conteudo' => 'required|max:1000',
        ]);

        $artigo->comentarios()->create([
            'user_id' => auth()->id(),
            'conteudo' => $request->input('conteudo'),
        ]);

        return redirect()->back()->with('success', 'Comentário adicionado!');
    }

}
