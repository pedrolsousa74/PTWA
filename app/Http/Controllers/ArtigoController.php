<?php

namespace App\Http\Controllers;


use App\Models\Artigo;
use Illuminate\Http\Request;

class ArtigoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'subtitulo' => 'nullable',
            'categoria' => 'required',
            'conteudo' => 'required',
        ]);

        $artigo = Artigo::create([
            'titulo' => $request->input('titulo'),
            'subtitulo' => $request->input('subtitulo'),
            'categoria' => $request->input('categoria'),
            'conteudo' => $request->input('conteudo'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('home')->with('success', 'Artigo criado com sucesso!');
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
