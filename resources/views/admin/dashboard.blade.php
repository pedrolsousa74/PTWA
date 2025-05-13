@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard de Administração')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Estatísticas -->    <div class="bg-white rounded-lg shadow p-6">        <h3 class="text-xl font-semibold mb-4 text-purple-800">Total de Utilizadores</h3>
        <p class="text-3xl font-bold">{{ $totalUtilizadores }}</p>
        <p class="text-sm text-gray-500 mt-2">
            <span class="text-green-600">{{ $totalAdmins }}</span> administradores
        </p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4 text-purple-800">Total de Artigos</h3>
        <p class="text-3xl font-bold">{{ $totalArtigos }}</p>
        <p class="text-sm text-gray-500 mt-2">
            Em {{ $artigosPorCategoria->count() }} categorias diferentes
        </p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4 text-purple-800">Total de Comentários</h3>
        <p class="text-3xl font-bold">{{ $totalComentarios }}</p>
        <p class="text-sm text-gray-500 mt-2">
            Média de {{ $totalArtigos > 0 ? round($totalComentarios / $totalArtigos, 1) : 0 }} por artigo
        </p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4 text-purple-800">Utilizador Atual</h3>
        <p class="text-lg">{{ Auth::user()->name }}</p>
        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
        <p class="mt-2 text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded inline-block">
            <i class="fas fa-user-shield"></i> Administrador
        </p>
    </div>
</div>

<!-- Estatísticas avançadas -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Artigos por categoria -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4 text-purple-800">Artigos por Categoria</h3>
        @if($artigosPorCategoria->count() > 0)
            <div class="space-y-2">
                @foreach($artigosPorCategoria as $categoria)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-800 font-medium">{{ ucfirst($categoria->categoria) }}</span>
                        <div class="flex items-center">
                            <div class="bg-purple-200 h-4 rounded-full" style="width: {{ min(100, $categoria->total / $totalArtigos * 100) * 2 }}px;"></div>
                            <span class="ml-2 text-gray-600">{{ $categoria->total }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Nenhum artigo publicado ainda.</p>
        @endif
    </div>
      <!-- Utilizadores mais ativos -->
    <div class="bg-white rounded-lg shadow p-6">        <h3 class="text-xl font-semibold mb-4 text-purple-800">Utilizadores Mais Ativos</h3>
        @if($utilizadoresMaisAtivos->count() > 0)
            <div class="space-y-4">
                @foreach($utilizadoresMaisAtivos as $utilizador)                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800 font-medium">{{ $utilizador->name }}</span>
                            <p class="text-sm text-gray-500">{{ $utilizador->email }}</p>
                        </div>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">
                            {{ $utilizador->artigos_count }} artigos
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Nenhum utilizador com artigos ainda.</p>
        @endif
    </div>
</div>

<!-- Conteúdo recente -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <!-- Últimos artigos -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4 text-purple-800">Últimos Artigos</h3>
        @if($ultimosArtigos->count() > 0)
            <div class="space-y-4">
                @foreach($ultimosArtigos as $artigo)
                    <div class="border-b pb-4">
                        <h4 class="font-semibold">{{ $artigo->titulo }}</h4>
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>Por {{ $artigo->user->name }}</span>
                            <span>{{ $artigo->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="mt-2">                            <a href="{{ route('artigos.show', $artigo->id) }}" class="text-blue-600 hover:underline mr-3">Ver</a>
                            <a href="{{ route('admin.artigos') }}" class="text-purple-600 hover:underline">Gerir Artigos</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Nenhum artigo publicado ainda.</p>
        @endif
    </div>
    
    <!-- Últimos comentários -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4 text-purple-800">Últimos Comentários</h3>
        @if($ultimosComentarios->count() > 0)
            <div class="space-y-4">
                @foreach($ultimosComentarios as $comentario)
                    <div class="border-b pb-4">
                        <p class="text-gray-700">{{ Str::limit($comentario->conteudo, 100) }}</p>
                        <div class="flex justify-between items-center text-sm text-gray-600 mt-2">
                            <span>Por {{ $comentario->user->name }}</span>
                            <span>{{ $comentario->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="mt-1">                            <a href="{{ route('artigos.show', $comentario->artigo_id) }}" class="text-blue-600 hover:underline mr-3">Ver Artigo</a>
                            <a href="{{ route('admin.comentarios') }}" class="text-purple-600 hover:underline">Gerir Comentários</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Nenhum comentário publicado ainda.</p>
        @endif
    </div>
</div>

<!-- Artigos mais comentados e utilizadores recentes -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Artigos mais comentados -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4 text-purple-800">Artigos Mais Comentados</h3>
        @if($artigosMaisComentados->count() > 0)
            <div class="space-y-4">
                @foreach($artigosMaisComentados as $artigo)
                    <div class="border-b pb-4">
                        <h4 class="font-semibold">{{ $artigo->titulo }}</h4>
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">
                                {{ $artigo->comentarios_count }} comentários
                            </span>
                            <a href="{{ route('artigos.show', $artigo->id) }}" class="text-blue-600 hover:underline">
                                Ver Artigo
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Nenhum artigo com comentários ainda.</p>
        @endif
    </div>
      <!-- Utilizadores recentes -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4 text-purple-800">Novos Utilizadores</h3>
        @if($utilizadoresRecentes->count() > 0)
            <div class="space-y-4">
                @foreach($utilizadoresRecentes as $utilizador)                    <div class="border-b pb-4">
                        <h4 class="font-semibold">{{ $utilizador->name }}</h4>
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>{{ $utilizador->email }}</span>
                            <span>{{ $utilizador->created_at->format('d/m/Y') }}</span>
                        </div>
                        @if($utilizador->isAdmin())
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded inline-block mt-1">
                                <i class="fas fa-user-shield"></i> Administrador
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Nenhum utilizador registado recentemente.</p>
        @endif
    </div>
</div>
@endsection
