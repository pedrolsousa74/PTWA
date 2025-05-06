<?php

namespace App\Http\Controllers;

use App\Models\Artigo;
use Illuminate\Http\Request;

class ArtigoController extends Controller
{
    public function store(Request $request)
    {
        Artigo::create([
            'titulo' => $request->titulo,
            'subtitulo' => $request->subtitulo,
            'categoria' => $request->categoria,
            'conteudo' => $request->conteudo,
        ]);

        return redirect()->route('home')->with('success', 'Artigo publicado com sucesso!');
    }

    public function index()
    {
        $artigos = Artigo::orderBy('created_at', 'desc')->get();
        return view('artigos', compact('artigos'));
    }

    public function show($id)
    {
        $artigo = Artigo::findOrFail($id);
        return view('lermais', compact('artigo'));
    }



}
