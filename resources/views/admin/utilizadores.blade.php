@extends('layouts.admin')

@section('title', 'Gerir Utilizadores')

@section('page-title', 'Gerir Utilizadores')

@section('content')
<!-- Cabeçalho com estatísticas rápidas e pesquisa -->
<div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-6">
    <!-- Estatísticas rápidas -->
    <div class="flex flex-wrap gap-4 mb-4 lg:mb-0">
        <div class="bg-purple-50 border border-purple-100 rounded-lg px-4 py-3 flex items-center">
            <div class="rounded-full bg-purple-100 p-2 mr-3">
                <i class="fas fa-users text-purple-600"></i>
            </div>
            <div>
                <p class="text-xs text-purple-600 font-medium uppercase">Total</p>
                <p class="text-lg font-semibold">{{ $utilizadores->total() }}</p>
            </div>
        </div>
        
        <div class="bg-blue-50 border border-blue-100 rounded-lg px-4 py-3 flex items-center">
            <div class="rounded-full bg-blue-100 p-2 mr-3">
                <i class="fas fa-user-shield text-blue-600"></i>
            </div>
            <div>
                <p class="text-xs text-blue-600 font-medium uppercase">Admins</p>
                <p class="text-lg font-semibold">{{ $utilizadores->where('is_admin', 1)->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Formulário de pesquisa -->
    <div class="w-full lg:w-auto">
        <form action="{{ route('admin.utilizadores') }}" method="GET" class="flex">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" 
                       placeholder="Pesquisar por nome ou email..." 
                       class="w-full pl-10 pr-10 py-2 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
                @if(isset($search) && !empty($search))
                    <a href="{{ route('admin.utilizadores') }}" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
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
            <span class="ml-2 bg-blue-200 text-blue-800 py-1 px-2 rounded-full text-xs">{{ $utilizadores->total() }} encontrados</span>
        </div>
        <a href="{{ route('admin.utilizadores') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <i class="fas fa-times-circle mr-1"></i> Limpar
        </a>
    </div>
@endif

<div class="bg-white rounded-lg overflow-hidden border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conteúdo</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Registo</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Função</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if($utilizadores->count() > 0)
                    @foreach($utilizadores as $utilizador)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                        <span class="font-medium text-purple-800 text-lg">{{ substr($utilizador->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $utilizador->name }}</div>
                                        <div class="text-xs text-gray-500">ID: #{{ $utilizador->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $utilizador->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-newspaper mr-1"></i> {{ $utilizador->artigos_count }} artigos
                                    </span>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-comments mr-1"></i> {{ $utilizador->comentarios_count }} comentários
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $utilizador->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $utilizador->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($utilizador->isAdmin())
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-user-shield mr-1"></i> Administrador
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <i class="fas fa-user mr-1"></i> Utilizador
                                    </span>
                                @endif
                            </td>                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            @if($utilizador->isAdmin())
                                @if(auth()->id() != $utilizador->id)
                                    <form action="{{ route('admin.utilizadores.despromover', $utilizador->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 px-3 py-1 rounded-md flex items-center transition-colors duration-200" onclick="return confirm('Tens a certeza que queres remover os privilégios de administrador deste utilizador?')">
                                            <i class="fas fa-user-minus mr-1"></i> Remover Admin
                                        </button>
                                    </form>
                                @else
                                    <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded-md flex items-center">
                                        <i class="fas fa-user-shield mr-1"></i> Tu mesmo
                                    </span>
                                @endif
                            @else
                                <form action="{{ route('admin.utilizadores.promover', $utilizador->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1 rounded-md flex items-center transition-colors duration-200" onclick="return confirm('Tens a certeza que queres promover este utilizador a administrador?')">
                                        <i class="fas fa-user-plus mr-1"></i> Promover
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.utilizadores.destroy', $utilizador->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1 rounded-md flex items-center transition-colors duration-200" onclick="return confirm('ATENÇÃO: Esta ação irá eliminar o utilizador e TODOS os seus artigos e comentários permanentemente! Tens a certeza?')">
                                        <i class="fas fa-trash mr-1"></i> Eliminar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <i class="fas fa-users text-3xl mb-3"></i>
                            <p>Não foram encontrados utilizadores</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Paginação com estilo melhorado -->
<div class="mt-6">
    @if($utilizadores->hasPages())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3">
            {{ $utilizadores->links() }}
        </div>
    @endif
    <div class="text-center text-sm text-gray-600 mt-2">
        Mostrando {{ $utilizadores->firstItem() ?? 0 }} a {{ $utilizadores->lastItem() ?? 0 }} de {{ $utilizadores->total() }} utilizadores
    </div>
</div>
@endsection
