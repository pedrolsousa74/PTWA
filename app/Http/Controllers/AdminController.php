<?php

namespace App\Http\Controllers;

use App\Models\Artigo;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class AdminController extends Controller
{    /**
     * Exibir o painel de administração com estatísticas
     */
    public function index()
    {        // Contagens totais
        $totalUtilizadores = User::count();
        $totalArtigos = Artigo::count();
        $totalComentarios = Comentario::count();
        
        // Contagem de administradores
        $totalAdmins = User::where('is_admin', true)->count();
        
        // Artigos por categoria
        $artigosPorCategoria = Artigo::selectRaw('categoria, count(*) as total')
            ->groupBy('categoria')
            ->get();
              // Utilizadores mais ativos (com mais artigos)
        $utilizadoresMaisAtivos = User::withCount('artigos')
            ->orderBy('artigos_count', 'desc')
            ->take(5)
            ->get();
            
        // Artigos mais comentados
        $artigosMaisComentados = Artigo::withCount('comentarios')
            ->orderBy('comentarios_count', 'desc')
            ->take(5)
            ->get();
        
        // Conteúdo recente
        $ultimosArtigos = Artigo::with('user')->latest()->take(5)->get();
        $ultimosComentarios = Comentario::with(['user', 'artigo'])->latest()->take(5)->get();        $utilizadoresRecentes = User::latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUtilizadores',
            'totalArtigos',
            'totalComentarios',
            'totalAdmins',
            'artigosPorCategoria',
            'utilizadoresMaisAtivos',
            'artigosMaisComentados',
            'ultimosArtigos',
            'ultimosComentarios',
            'utilizadoresRecentes'
        ));
    }
      /**
     * Listar todos os artigos com opção de pesquisa
     */
    public function artigos(Request $request)
    {
        $search = $request->input('search');
        
        $query = Artigo::with('user');
        
        // Aplicar filtro de pesquisa, se houver
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', '%' . $search . '%')
                  ->orWhere('conteudo', 'like', '%' . $search . '%')
                  ->orWhere('categoria', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                              ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }
        
        $artigos = $query->latest()->paginate(10);
        
        // Manter o parâmetro de pesquisa na paginação
        $artigos->appends(['search' => $search]);
        
        return view('admin.artigos', compact('artigos', 'search'));
    }
    
    /**
     * Remover um artigo (apenas para administradores)
     */
    public function destroyArtigo($id)
    {
        $artigo = Artigo::findOrFail($id);
        
        // Remover a imagem associada, se existir
        if ($artigo->imagem) {
            \Storage::delete('public/artigos/' . $artigo->imagem);
        }
          // Eliminar comentários associados ao artigo
        $artigo->comentarios()->delete();
        
        // Eliminar relações de likes
        $artigo->usersWhoLiked()->detach();
        
        // Eliminar o artigo
        $artigo->delete();
        
        return redirect()->back()->with('success', 'Artigo eliminado com sucesso!');
    }    /**
     * Listar todos os utilizadores
     */    public function utilizadores(Request $request)
    {
        $search = $request->input('search');
        
        $query = User::withCount(['artigos', 'comentarios']);
        
        // Aplicar filtro de pesquisa, se houver
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
          $utilizadores = $query->latest()->paginate(10);
        
        // Manter o parâmetro de pesquisa na paginação
        $utilizadores->appends(['search' => $search]);
        
        return view('admin.utilizadores', compact('utilizadores', 'search'));
    }
      /**
     * Promover um utilizador a administrador
     */
    public function promoverUtilizador($id)
    {
        $utilizador = User::findOrFail($id);
        $utilizador->is_admin = true;
        $utilizador->save();
        
        return redirect()->back()->with('success', 'Utilizador promovido a administrador com sucesso!');
    }
      /**
     * Revogar privilégios de administrador
     */
    public function despromoverUtilizador($id)
    {
        // Não permitir despromover o próprio utilizador
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'Não podes remover os teus próprios privilégios de administrador.');
        }
        
        $utilizador = User::findOrFail($id);
        $utilizador->is_admin = false;
        $utilizador->save();
        
        return redirect()->back()->with('success', 'Privilégios de administrador revogados com sucesso!');
    }
    
    /**
     * Eliminar um utilizador e todos os seus dados associados
     */    public function destroyUtilizador($id)    {        // Não permitir eliminar o próprio utilizador logado
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'Não é possível eliminar o seu próprio utilizador.');
        }
        
        $utilizador = User::findOrFail($id);
          // Verificar se o utilizador a ser eliminado é um administrador
        if ($utilizador->isAdmin()) {
            return redirect()->back()->with('error', 'Não é possível eliminar um utilizador administrador. Remova os privilégios de administrador primeiro.');
        }
          // Eliminar artigos do utilizador (e todas as suas relações: comentários, likes, etc)
        foreach ($utilizador->artigos as $artigo) {
            // Remover a imagem do artigo, se existir
            if ($artigo->imagem) {
                \Storage::delete('public/artigos/' . $artigo->imagem);
            }
              // Eliminar relações de likes
            $artigo->usersWhoLiked()->detach();
            
            // Eliminar comentários do artigo
            $artigo->comentarios()->delete();
            
            // Eliminar o artigo
            $artigo->delete();
        }
          // Eliminar comentários feitos pelo utilizador em outros artigos
        $utilizador->comentarios()->delete();
        
        // Remover relações de likes do utilizador
        $utilizador->likes()->detach();
        
        // Eliminar o utilizador
        $utilizador->delete();
        
        return redirect()->back()->with('success', 'Utilizador eliminado com sucesso!');
    }
    
    /**
     * Listar todos os comentários com opção de pesquisa
     */
    public function comentarios(Request $request)
    {
        $search = $request->input('search');
        
        $query = Comentario::with(['user', 'artigo'])->latest();
        
        // Filtrar por termo de pesquisa se fornecido
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('conteudo', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('artigo', function($artigoQuery) use ($search) {
                      $artigoQuery->where('titulo', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        $comentarios = $query->paginate(15)->withQueryString();
        return view('admin.comentarios', compact('comentarios'));
    }
    
    /**
     * Remover um comentário
     */
    public function destroyComentario($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();
        
        return redirect()->back()->with('success', 'Comentário eliminado com sucesso!');
    }
}
