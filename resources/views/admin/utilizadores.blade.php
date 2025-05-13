@extends('layouts.admin')

@section('title', 'Gerir Utilizadores')

@section('page-title', 'Gerir Utilizadores')

@section('content')
<!-- Formulário de pesquisa -->
<div class="mb-6">
    <form action="{{ route('admin.utilizadores') }}" method="GET" class="flex">
        <div class="relative flex-grow">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Pesquisar por nome ou email..." 
                   class="w-full px-4 py-2 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
            @if(isset($search) && !empty($search))
                <a href="{{ route('admin.utilizadores') }}" class="absolute right-2 top-2 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </div>
        <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-r-md">
            <i class="fas fa-search"></i> Pesquisar
        </button>
    </form>
</div>

@if(isset($search) && !empty($search))
    <div class="mb-4 text-sm bg-blue-50 p-3 rounded-md">
        A mostrar resultados para: <strong>{{ $search }}</strong>
        <span class="text-gray-600">({{ $utilizadores->total() }} encontrados)</span>
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conteúdo</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Registo</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Função</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($utilizadores as $utilizador)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $utilizador->name }}</div>
                    </td>                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $utilizador->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                <i class="fas fa-newspaper mr-1"></i> {{ $utilizador->artigos_count }} artigos
                            </span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-comments mr-1"></i> {{ $utilizador->comentarios_count }} comentários
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $utilizador->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($utilizador->isAdmin())
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Administrador
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Utilizador
                            </span>
                        @endif
                    </td>                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-3">
                            @if($utilizador->isAdmin())
                                @if(auth()->id() != $utilizador->id)
                                    <form action="{{ route('admin.utilizadores.despromover', $utilizador->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900" onclick="return confirm('Tens a certeza que queres remover os privilégios de administrador deste utilizador?')">
                                            <i class="fas fa-user-minus"></i> Remover Admin
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-500"><i class="fas fa-user-shield"></i> Tu mesmo</span>
                                @endif
                            @else
                                <div class="flex space-x-3">
                                    <form action="{{ route('admin.utilizadores.promover', $utilizador->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-blue-600 hover:text-blue-900" onclick="return confirm('Tens a certeza que queres promover este utilizador a administrador?')">
                                            <i class="fas fa-user-plus"></i> Promover
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.utilizadores.destroy', $utilizador->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('ATENÇÃO: Esta ação irá eliminar o utilizador e TODOS os seus artigos e comentários permanentemente! Tens a certeza?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $utilizadores->links() }}
</div>
@endsection
