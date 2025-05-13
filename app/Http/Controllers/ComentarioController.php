<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artigo;
use App\Models\Comentario;


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

    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        
        // Verificar se o usuário é dono do comentário ou admin
        if (auth()->id() !== $comentario->user_id && !auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Não tens permissão para apagar este comentário.');
        }
        
        $comentario->delete();
        return redirect()->back()->with('success', 'Comentário eliminado com sucesso!');
    }
}
