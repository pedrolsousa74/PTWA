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
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // validação do ficheiro
        ]);

        $nomeImagem = null;

        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $nomeImagem = uniqid() . '.' . $imagem->getClientOriginalExtension();
            $imagem->storeAs('public/artigos', $nomeImagem);
        }

        Artigo::create([
            'titulo' => $request->input('titulo'),
            'subtitulo' => $request->input('subtitulo'),
            'categoria' => $request->input('categoria'),
            'conteudo' => $request->input('conteudo'),
            'user_id' => auth()->id(),
            'imagem' => $nomeImagem,
        ]);

        return redirect()->route('home')->with('success', 'Artigo criado com sucesso!');
    }






    public function index(Request $request)
    {
        $categoria = $request->query('categoria');
        $data = $request->query('data');

        // Verifica se a data fornecida está no futuro, caso sim, retorna uma coleção vazia.
        if ($data && strtotime($data) > strtotime(now()->toDateString())) {
            // Se a data for no futuro, não há artigos para mostrar
            $artigos = collect();  // Retorna uma coleção vazia
        } else {
            // Caso contrário, filtra os artigos conforme a categoria e data
            $artigos = Artigo::with('user', 'usersWhoLiked') // Carregar o relacionamento 'user' com os artigos
                ->when($categoria, function($query) use ($categoria) {
                    return $query->where('categoria', $categoria);
                })
                ->when($data, function($query) use ($data) {
                    // Filtra artigos com data maior ou igual a data fornecida
                    return $query->whereDate('created_at', '>=', $data);
                })
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Se a data fornecida for anterior ao dia atual, mostramos apenas artigos a partir dessa data
            if ($data && strtotime($data) < strtotime('2025-05-10')) {
                $artigos = collect(); // Retorna uma coleção vazia se a data for antes de 10/05/2025
            }
        }

        return view('artigos', compact('artigos'));
    }

    public function show($id)
    {
        $artigo = Artigo::findOrFail($id);
        return view('lermais', compact('artigo'));
    }

    public function like($id)
    {
        $artigo = Artigo::findOrFail($id);
        $user = auth()->user();

        if ($artigo->usersWhoLiked->contains($user)) {
            $artigo->usersWhoLiked()->detach($user); // remover like
        } else {
            $artigo->usersWhoLiked()->attach($user); // adicionar like
        }

        return redirect()->back();
    }

    public function homepage()
    {
        $tendencias = Artigo::withCount('usersWhoLiked')
            ->orderByDesc('users_who_liked_count')
            ->take(4)
            ->get();

        return view('home', compact('tendencias'));
    }





}
