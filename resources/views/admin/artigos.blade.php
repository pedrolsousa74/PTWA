@extends('layouts.admin')

@section('title', 'Gerir Artigos')

@section('page-title', 'Gerir Artigos')

@section('content')
<!-- Cabeçalho com estatísticas rápidas e pesquisa -->
<div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-6">
    <!-- Estatísticas rápidas -->
    <div class="flex flex-wrap gap-4 mb-4 lg:mb-0">
        <div class="bg-purple-50 border border-purple-100 rounded-lg px-4 py-3 flex items-center">
            <div class="rounded-full bg-purple-100 p-2 mr-3">
                <i class="fas fa-newspaper text-purple-600"></i>
            </div>
            <div>
                <p class="text-xs text-purple-600 font-medium uppercase">Total</p>
                <p class="text-lg font-semibold">{{ $artigos->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Formulário de pesquisa -->
    <div class="w-full lg:w-auto">
        <form action="{{ route('admin.artigos') }}" method="GET" class="flex">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" 
                       placeholder="Pesquisar por título, conteúdo ou autor..." 
                       class="w-full pl-10 pr-10 py-2 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
                @if(isset($search) && !empty($search))
                    <a href="{{ route('admin.artigos') }}" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
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

@if(isset($search) && !empty($search))
    <div class="mb-6 text-sm bg-blue-50 border border-blue-100 p-4 rounded-lg flex items-center justify-between">
        <div>
            <i class="fas fa-filter text-blue-500 mr-2"></i>
            A mostrar resultados para: <strong class="text-blue-700">{{ $search }}</strong>
            <span class="ml-2 bg-blue-200 text-blue-800 py-1 px-2 rounded-full text-xs">{{ $artigos->total() }} encontrados</span>
        </div>
        <a href="{{ route('admin.artigos') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <i class="fas fa-times-circle mr-1"></i> Limpar
        </a>
    </div>
@endif

<div class="bg-white rounded-lg overflow-hidden border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if($artigos->count() > 0)
                    @foreach($artigos as $artigo)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 line-clamp-1">{{ $artigo->titulo }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    ID: #{{ $artigo->id }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-purple-200 flex items-center justify-center">
                                        <span class="font-medium text-purple-800">{{ substr($artigo->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $artigo->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $artigo->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    {{ ucfirst($artigo->categoria) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $artigo->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $artigo->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{ route('artigos.show', $artigo->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-md transition-colors duration-200" target="_blank" title="Ver artigo">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.artigos.destroy', $artigo->id) }}" method="POST" onsubmit="return confirm('Tens a certeza que queres eliminar este artigo? Esta ação não pode ser revertida.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-md transition-colors duration-200" title="Eliminar artigo">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <i class="fas fa-folder-open text-3xl mb-3"></i>
                            <p>Não foram encontrados artigos</p>
                        </td>
                    </tr>
                @endif            </tbody>
        </table>
    </div>
</div>

<!-- Paginação com estilo melhorado -->
<div class="mt-6">
    @if($artigos->hasPages())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3">
            {{ $artigos->links() }}
        </div>
    @endif
    <div class="text-center text-sm text-gray-600 mt-2">
        Mostrando {{ $artigos->firstItem() ?? 0 }} a {{ $artigos->lastItem() ?? 0 }} de {{ $artigos->total() }} artigos
    </div>
</div>
@endsection
