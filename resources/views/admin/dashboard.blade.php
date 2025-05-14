@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard de Administração')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Estatísticas -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 transform transition-transform duration-300 hover:shadow-md hover:scale-102">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-purple-800">Utilizadores</h3>
            <div class="rounded-full bg-purple-100 p-3">
                <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $totalUtilizadores }}</p>
        <div class="mt-3 flex items-center text-sm text-gray-500">
            <span class="flex items-center text-green-600">
                <i class="fas fa-user-shield mr-1"></i> {{ $totalAdmins }} administradores
            </span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.utilizadores') }}" class="text-purple-600 hover:text-purple-800 text-sm flex items-center">
                Ver detalhes <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 transform transition-transform duration-300 hover:shadow-md hover:scale-102">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-blue-800">Artigos</h3>
            <div class="rounded-full bg-blue-100 p-3">
                <i class="fas fa-newspaper text-blue-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $totalArtigos }}</p>
        <div class="mt-3 flex items-center text-sm text-gray-500">
            <i class="fas fa-layer-group mr-1"></i> {{ $artigosPorCategoria->count() }} categorias diferentes
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.artigos') }}" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                Ver detalhes <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 transform transition-transform duration-300 hover:shadow-md hover:scale-102">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-amber-800">Comentários</h3>
            <div class="rounded-full bg-amber-100 p-3">
                <i class="fas fa-comments text-amber-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $totalComentarios }}</p>
        <div class="mt-3 flex items-center text-sm text-gray-500">
            <i class="fas fa-calculator mr-1"></i> Média de {{ $totalArtigos > 0 ? round($totalComentarios / $totalArtigos, 1) : 0 }} por artigo
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.comentarios') }}" class="text-amber-600 hover:text-amber-800 text-sm flex items-center">
                Ver detalhes <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 transform transition-transform duration-300 hover:shadow-md hover:scale-102">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-green-800">Seu Perfil</h3>
            <div class="rounded-full bg-green-100 p-3">
                <i class="fas fa-user-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mb-2 flex items-center">
            <div class="w-12 h-12 rounded-full bg-purple-200 flex items-center justify-center mr-3">
                <span class="font-bold text-purple-800 text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div>
                <p class="text-lg font-medium">{{ Auth::user()->name }}</p>
                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <p class="mt-3 bg-purple-100 text-purple-800 px-3 py-1 rounded-full inline-flex items-center text-sm">
            <i class="fas fa-user-shield mr-1"></i> Administrador
        </p>
    </div>
</div>

<!-- Estatísticas avançadas -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Artigos por categoria -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-purple-800">Artigos por Categoria</h3>
            <div class="text-purple-600">
                <i class="fas fa-chart-pie"></i>
            </div>
        </div>
        @if($artigosPorCategoria->count() > 0)
            <div class="space-y-3">
                @foreach($artigosPorCategoria as $categoria)
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-800 font-medium capitalize">{{ $categoria->categoria }}</span>
                            <span class="text-sm text-gray-600 font-medium">{{ $categoria->total }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-purple-600 h-2.5 rounded-full" style="width: {{ min(100, $categoria->total / $totalArtigos * 100) }}%"></div>
                        </div>
                        <p class="text-xs text-right text-gray-500 mt-1">{{ round($categoria->total / $totalArtigos * 100) }}% do total</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-6 text-gray-500">
                <i class="fas fa-chart-bar text-3xl mb-2"></i>
                <p>Nenhum artigo publicado ainda.</p>
            </div>
        @endif
    </div>
      
    <!-- Utilizadores mais ativos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-blue-800">Utilizadores Mais Ativos</h3>
            <div class="text-blue-600">
                <i class="fas fa-trophy"></i>
            </div>
        </div>
        @if($utilizadoresMaisAtivos->count() > 0)
            <div class="space-y-4">
                @foreach($utilizadoresMaisAtivos as $utilizador)
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-200 flex items-center justify-center mr-3">
                                <span class="font-medium text-blue-800">{{ substr($utilizador->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-800 font-medium">{{ $utilizador->name }}</span>
                                <p class="text-xs text-gray-500">{{ $utilizador->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-newspaper mr-1"></i> {{ $utilizador->artigos_count }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-6 text-gray-500">
                <i class="fas fa-users text-3xl mb-2"></i>
                <p>Nenhum utilizador com artigos ainda.</p>
            </div>
        @endif
    </div>
</div>

<!-- Conteúdo recente -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <!-- Últimos artigos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-purple-800">Últimos Artigos</h3>
            <a href="{{ route('admin.artigos') }}" class="text-sm text-purple-600 hover:text-purple-800 flex items-center">
                Ver todos <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>
        </div>
        @if($ultimosArtigos->count() > 0)
            <div class="space-y-5">
                @foreach($ultimosArtigos as $artigo)
                    <div class="border-b border-gray-100 pb-4">
                        <div class="flex items-start">
                            <div class="bg-purple-100 text-purple-800 rounded-md p-2 mr-3">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800">{{ $artigo->titulo }}</h4>
                                <div class="flex flex-wrap justify-between items-center text-xs text-gray-500 mt-1">
                                    <span class="flex items-center">
                                        <i class="fas fa-user mr-1"></i> {{ $artigo->user->name }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="far fa-clock mr-1"></i> {{ $artigo->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 flex space-x-2">
                            <a href="{{ route('artigos.show', $artigo->id) }}" class="bg-blue-50 text-blue-700 hover:bg-blue-100 px-3 py-1 rounded-md text-xs flex items-center transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i> Visualizar
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                <i class="fas fa-newspaper text-3xl mb-2"></i>
                <p>Nenhum artigo publicado ainda.</p>
            </div>
        @endif
    </div>
    
    <!-- Últimos comentários -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-amber-800">Últimos Comentários</h3>
            <a href="{{ route('admin.comentarios') }}" class="text-sm text-amber-600 hover:text-amber-800 flex items-center">
                Ver todos <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>
        </div>
        @if($ultimosComentarios->count() > 0)
            <div class="space-y-5">
                @foreach($ultimosComentarios as $comentario)
                    <div class="border-b border-gray-100 pb-4">
                        <div class="flex items-start">
                            <div class="bg-amber-100 text-amber-800 rounded-md p-2 mr-3">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-700 text-sm">{{ Str::limit($comentario->conteudo, 100) }}</p>
                                <div class="flex flex-wrap justify-between items-center text-xs text-gray-500 mt-2">
                                    <span class="flex items-center">
                                        <i class="fas fa-user mr-1"></i> {{ $comentario->user->name }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="far fa-clock mr-1"></i> {{ $comentario->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 flex space-x-2">
                            <a href="{{ route('artigos.show', $comentario->artigo_id) }}" class="bg-blue-50 text-blue-700 hover:bg-blue-100 px-3 py-1 rounded-md text-xs flex items-center transition-colors duration-200">
                                <i class="fas fa-file-alt mr-1"></i> Ver Artigo
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                <i class="fas fa-comments text-3xl mb-2"></i>
                <p>Nenhum comentário publicado ainda.</p>
            </div>
        @endif
    </div>
</div>

<!-- Artigos mais comentados e utilizadores recentes -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Artigos mais comentados -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-green-800">Artigos Mais Comentados</h3>
            <div class="bg-green-100 text-green-800 p-2 rounded-md">
                <i class="fas fa-fire"></i>
            </div>
        </div>
        @if($artigosMaisComentados->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($artigosMaisComentados as $artigo)
                    <div class="py-4">
                        <div class="flex items-center justify-between">
                            <h4 class="font-medium text-gray-800 flex-1 pr-4">{{ $artigo->titulo }}</h4>
                            <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full flex items-center text-sm font-medium">
                                <i class="fas fa-comments mr-1"></i> {{ $artigo->comentarios_count }}
                            </span>
                        </div>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Por {{ $artigo->user->name }}</span>
                            <a href="{{ route('artigos.show', $artigo->id) }}" class="bg-blue-50 text-blue-700 hover:bg-blue-100 px-3 py-1 rounded-md text-xs flex items-center transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i> Ver Artigo
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                <i class="fas fa-comment-slash text-3xl mb-2"></i>
                <p>Nenhum artigo com comentários ainda.</p>
            </div>
        @endif
    </div>
    
    <!-- Utilizadores recentes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-indigo-800">Novos Utilizadores</h3>
            <div class="bg-indigo-100 text-indigo-800 p-2 rounded-md">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
        @if($utilizadoresRecentes->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($utilizadoresRecentes as $utilizador)
                    <div class="py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-indigo-200 flex items-center justify-center mr-3">
                                <span class="font-medium text-indigo-800">{{ substr($utilizador->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $utilizador->name }}</h4>
                                <div class="flex flex-wrap justify-between text-xs text-gray-500">
                                    <span>{{ $utilizador->email }}</span>
                                    <span class="ml-3"><i class="far fa-calendar mr-1"></i> {{ $utilizador->created_at->format('d/m/Y') }}</span>
                                </div>
                                @if($utilizador->isAdmin())
                                    <span class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full inline-flex items-center mt-2">
                                        <i class="fas fa-user-shield mr-1"></i> Administrador
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                <i class="fas fa-user-times text-3xl mb-2"></i>
                <p>Nenhum utilizador registado recentemente.</p>
            </div>
        @endif
    </div>
</div>
@endsection
