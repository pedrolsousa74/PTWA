@extends('layouts.admin')

@section('title', 'Gerir Comentários')

@section('page-title', 'Gerir Comentários')

@section('content')
<!-- Cabeçalho com estatísticas rápidas e pesquisa -->
<div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-6">
    <!-- Estatísticas rápidas -->
    <div class="flex flex-wrap gap-4 mb-4 lg:mb-0">
        <div class="bg-amber-50 border border-amber-100 rounded-lg px-4 py-3 flex items-center">
            <div class="rounded-full bg-amber-100 p-2 mr-3">
                <i class="fas fa-comments text-amber-600"></i>
            </div>
            <div>
                <p class="text-xs text-amber-600 font-medium uppercase">Total</p>
                <p class="text-lg font-semibold">{{ $comentarios->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Formulário de pesquisa -->
    <div class="w-full lg:w-auto">
        <form action="{{ route('admin.comentarios') }}" method="GET" class="flex">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Pesquisar comentários..." 
                       class="w-full pl-10 pr-10 py-2 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
                @if(request('search'))
                    <a href="{{ route('admin.comentarios') }}" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
            <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white px-5 py-2 rounded-r-md transition-colors duration-200">
                Pesquisar
            </button>
        </form>
    </div>
</div>

@if(request('search'))
    <div class="mb-6 text-sm bg-blue-50 border border-blue-100 p-4 rounded-lg flex items-center justify-between">
        <div>
            <i class="fas fa-filter text-blue-500 mr-2"></i>
            A mostrar resultados para: <strong class="text-blue-700">{{ request('search') }}</strong>
            <span class="ml-2 bg-blue-200 text-blue-800 py-1 px-2 rounded-full text-xs">{{ $comentarios->total() }} encontrados</span>
        </div>
        <a href="{{ route('admin.comentarios') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <i class="fas fa-times-circle mr-1"></i> Limpar
        </a>
    </div>
@endif

<div class="bg-white rounded-lg overflow-hidden border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conteúdo</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artigo</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($comentarios as $comentario)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ Str::limit($comentario->conteudo, 100) }}</div>
                            <div class="text-xs text-gray-500 mt-1">
                                ID: #{{ $comentario->id }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-amber-200 flex items-center justify-center">
                                    <span class="font-medium text-amber-800">{{ substr($comentario->user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $comentario->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $comentario->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 font-medium">
                                <a href="{{ route('artigos.show', $comentario->artigo->id) }}" class="text-blue-600 hover:text-blue-900 hover:underline" target="_blank">
                                    {{ Str::limit($comentario->artigo->titulo, 50) }}
                                </a>
                            </div>
                            <div class="text-xs text-gray-500 mt-1 flex items-center">
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    {{ ucfirst($comentario->artigo->categoria) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $comentario->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $comentario->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <a href="{{ route('artigos.show', $comentario->artigo->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-md transition-colors duration-200" target="_blank" title="Ver artigo">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.comentarios.destroy', $comentario->id) }}" method="POST" onsubmit="return confirm('Tens a certeza que queres eliminar este comentário? Esta ação não pode ser revertida.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-md transition-colors duration-200" title="Eliminar comentário">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <i class="fas fa-comment-slash text-3xl mb-3"></i>
                            <p>Não foram encontrados comentários</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Paginação com estilo melhorado -->
<div class="mt-6">
    @if($comentarios->hasPages())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3">
            {{ $comentarios->links() }}
        </div>
    @endif
    <div class="text-center text-sm text-gray-600 mt-2">
        Mostrando {{ $comentarios->firstItem() ?? 0 }} a {{ $comentarios->lastItem() ?? 0 }} de {{ $comentarios->total() }} comentários
    </div>
</div>
@endsection
