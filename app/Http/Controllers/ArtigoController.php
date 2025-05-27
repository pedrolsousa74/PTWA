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

        // Inicializa como null para depois atribuir um valor
        $nomeImagem = null;

        if ($request->hasFile('imagem')) {
            try {
                $imagem = $request->file('imagem');
                
                // Generate unique name with timestamp to avoid conflicts
                $nomeImagem = time() . '_' . uniqid() . '.' . $imagem->getClientOriginalExtension();
                
                // Make sure directory exists
                $storage_path = storage_path('app/public/artigos');
                if (!file_exists($storage_path)) {
                    mkdir($storage_path, 0755, true);
                }
                
                // Try to move the uploaded file directly
                if ($imagem->move($storage_path, $nomeImagem)) {
                    // Also create a copy in the public path to ensure it's accessible
                    $public_path = public_path('storage/artigos');
                    if (!file_exists($public_path)) {
                        mkdir($public_path, 0755, true);
                    }
                    copy($storage_path . '/' . $nomeImagem, $public_path . '/' . $nomeImagem);
                } else {
                    $nomeImagem = null;
                    \Log::error('Failed to move uploaded image for article: ' . $request->input('titulo'));
                }
            } catch (\Exception $e) {
                $nomeImagem = null;
                \Log::error('Exception during image upload: ' . $e->getMessage());
            }
        } else {
            // Se nenhuma imagem foi enviada, use a imagem post-it como imagem genérica
            
            // Nome do arquivo de origem e extensão
            $sourceFileName = 'post-it.png';
            
            // Gerar nome único com timestamp para o arquivo de destino
            $nomeImagem = 'generic_' . time() . '_' . uniqid() . '.png';
            
            // Caminho de origem do arquivo (ícones estão em public/Icones)
            $sourcePath = public_path('Icones/' . $sourceFileName);
            
            if (file_exists($sourcePath)) {
                try {
                    // Criar diretórios se não existirem
                    $storage_path = storage_path('app/public/artigos');
                    $public_path = public_path('storage/artigos');
                    
                    if (!file_exists($storage_path)) {
                        mkdir($storage_path, 0755, true);
                    }
                    if (!file_exists($public_path)) {
                        mkdir($public_path, 0755, true);
                    }
                    
                    // Copiar o arquivo genérico para os diretórios de destino
                    copy($sourcePath, $storage_path . '/' . $nomeImagem);
                    copy($sourcePath, $public_path . '/' . $nomeImagem);
                    
                    \Log::info('Generic image assigned to article: ' . $request->input('titulo'));
                } catch (\Exception $e) {
                    $nomeImagem = null;
                    \Log::error('Exception during generic image assignment: ' . $e->getMessage());
                }
            } else {
                \Log::error('Generic image source not found: ' . $sourcePath);
            }
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
        $usuario = $request->query('usuario');
        $data = $request->query('data');
        
        // Lista de categorias disponíveis para o dropdown
        $categorias = ['tecnologia', 'ambiente', 'educacao', 'outros'];

        // Filtra os artigos conforme a categoria, autor e data
        $artigos = Artigo::with('user', 'usersWhoLiked') // Carregar o relacionamento 'user' com os artigos
            ->when($categoria, function($query) use ($categoria) {
                return $query->where('categoria', $categoria);
            })
            ->when($usuario, function($query) use ($usuario) {
                return $query->whereHas('user', function($q) use ($usuario) {
                    $q->where('name', 'like', '%' . $usuario . '%');
                });
            })
            ->when($data, function($query) use ($data) {
                // Filtra artigos com data exatamente igual à data fornecida
                return $query->whereDate('created_at', '=', $data);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            ->withQueryString();

        return view('artigos', compact('artigos', 'categorias'));
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
            try {
                // Exclui a imagem anterior, se existir
                if ($artigo->imagem) {
                    $old_storage_path = storage_path('app/public/artigos/' . $artigo->imagem);
                    $old_public_path = public_path('storage/artigos/' . $artigo->imagem);
                    
                    if (file_exists($old_storage_path)) {
                        unlink($old_storage_path);
                    }
                    
                    if (file_exists($old_public_path)) {
                        unlink($old_public_path);
                    }
                }
                
                // Processa a nova imagem
                $imagem = $request->file('imagem');
                $nomeImagem = time() . '_' . uniqid() . '.' . $imagem->getClientOriginalExtension();
                
                // Make sure directory exists
                $storage_path = storage_path('app/public/artigos');
                if (!file_exists($storage_path)) {
                    mkdir($storage_path, 0755, true);
                }
                
                // Try to move the uploaded file directly
                if ($imagem->move($storage_path, $nomeImagem)) {
                    // Also create a copy in the public path to ensure it's accessible
                    $public_path = public_path('storage/artigos');
                    if (!file_exists($public_path)) {
                        mkdir($public_path, 0755, true);
                    }
                    copy($storage_path . '/' . $nomeImagem, $public_path . '/' . $nomeImagem);
                    
                    $artigo->imagem = $nomeImagem;
                } else {
                    \Log::error('Failed to move uploaded image for article update: ' . $artigo->titulo);
                }
            } catch (\Exception $e) {
                \Log::error('Exception during image update: ' . $e->getMessage());
            }
        } else if ($request->has('remove_image') || ($artigo->imagem === null)) {
            // Se o usuário solicitou a remoção da imagem ou se não há imagem, atribua uma genérica
            // Se a requisição tem 'remove_image' ou se o artigo não tem imagem atualmente
            
            // Remove a imagem atual se existir
            if ($artigo->imagem) {
                $old_storage_path = storage_path('app/public/artigos/' . $artigo->imagem);
                $old_public_path = public_path('storage/artigos/' . $artigo->imagem);
                
                if (file_exists($old_storage_path)) {
                    unlink($old_storage_path);
                }
                
                if (file_exists($old_public_path)) {
                    unlink($old_public_path);
                }
            }
            
            // Use a imagem post-it como imagem genérica
            
            // Nome do arquivo de origem e extensão
            $sourceFileName = 'post-it.png';
            
            // Gerar nome único com timestamp para o arquivo de destino
            $nomeImagem = 'generic_' . time() . '_' . uniqid() . '.png';
            
            // Caminho de origem do arquivo (ícones estão em public/Icones)
            $sourcePath = public_path('Icones/' . $sourceFileName);
            
            if (file_exists($sourcePath)) {
                try {
                    // Criar diretórios se não existirem
                    $storage_path = storage_path('app/public/artigos');
                    $public_path = public_path('storage/artigos');
                    
                    if (!file_exists($storage_path)) {
                        mkdir($storage_path, 0755, true);
                    }
                    if (!file_exists($public_path)) {
                        mkdir($public_path, 0755, true);
                    }
                    
                    // Copiar o arquivo genérico para os diretórios de destino
                    copy($sourcePath, $storage_path . '/' . $nomeImagem);
                    copy($sourcePath, $public_path . '/' . $nomeImagem);
                    
                    $artigo->imagem = $nomeImagem;
                    \Log::info('Generic image assigned to article update: ' . $artigo->titulo);
                } catch (\Exception $e) {
                    \Log::error('Exception during generic image assignment in update: ' . $e->getMessage());
                }
            } else {
                \Log::error('Generic image source not found in update: ' . $sourcePath);
            }
        }

        $artigo->save();

        return redirect()->route('perfil')->with('success', 'Artigo atualizado com sucesso!');
    }
}
