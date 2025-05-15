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

    /**
     * Remove o artigo especificado da base de dados.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $artigo = Artigo::findOrFail($id);
        $isAdmin = auth()->user()->isAdmin();

        // Verificar se o usuário logado é o dono do artigo ou é administrador
        if (auth()->id() !== $artigo->user_id && !$isAdmin) {
            return redirect()->back()->with('error', 'Não tens permissão para apagar este artigo.');
        }

        // Remover a imagem associada ao artigo, se existir
        if ($artigo->imagem) {
            \Storage::delete('public/artigos/' . $artigo->imagem);
        }

        // Excluir o artigo
        $artigo->delete();

        // Se for um administrador excluindo o artigo de outro usuário, redirecionar para a página apropriada
        if ($isAdmin && auth()->id() !== $artigo->user_id) {
            return redirect()->route('admin.artigos')->with('success', 'Artigo eliminado com sucesso!');
        }

        return redirect()->route('perfil')->with('success', 'Artigo eliminado com sucesso!');
    }

    /**
     * Mostra o formulário para editar o artigo especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $artigo = Artigo::findOrFail($id);

        // Verificar se o usuário logado é o dono do artigo
        if (auth()->id() !== $artigo->user_id) {
            return redirect()->back()->with('error', 'Não tens permissão para editar este artigo.');
        }

        return view('publicar', compact('artigo'));
    }

    /**
     * Atualiza o artigo especificado na base de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',
            'subtitulo' => 'nullable',
            'categoria' => 'required',
            'conteudo' => 'required',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $artigo = Artigo::findOrFail($id);

        // Verificar se o usuário logado é o dono do artigo
        if (auth()->id() !== $artigo->user_id) {
            return redirect()->back()->with('error', 'Não tens permissão para editar este artigo.');
        }

        // Atualiza os dados do artigo
        $artigo->titulo = $request->input('titulo');
        $artigo->subtitulo = $request->input('subtitulo');
        $artigo->categoria = $request->input('categoria');
        $artigo->conteudo = $request->input('conteudo');

        // Verifica se foi enviada uma nova imagem
        if ($request->hasFile('imagem')) {
            // Exclui a imagem anterior, se existir
            if ($artigo->imagem) {
                \Storage::delete('public/artigos/' . $artigo->imagem);
            }

            // Salva a nova imagem
            $imagem = $request->file('imagem');
            $nomeImagem = uniqid() . '.' . $imagem->getClientOriginalExtension();
            $imagem->storeAs('public/artigos', $nomeImagem);
            $artigo->imagem = $nomeImagem;
        }

        $artigo->save();

        return redirect()->route('perfil')->with('success', 'Artigo atualizado com sucesso!');
    }

    /**
     * Exibe os artigos do usuário logado.
     *
     * @return \Illuminate\Http\Response
     */
    public function meusArtigos()
    {
        $artigos = auth()->user()->artigos()->latest()->get();
        $tendencias = Artigo::withCount('usersWhoLiked')
            ->orderByDesc('users_who_liked_count')
            ->take(4)
            ->get();
        
        return view('meus-artigos', compact('artigos', 'tendencias'));
    }
}
