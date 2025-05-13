@extends('layouts.admin')

@section('title', 'Gerir Comentários')

@section('page-title', 'Gerir Comentários')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <div>
        <h3 class="text-gray-700">Total: <span class="font-bold">{{ $comentarios->total() }}</span> comentários</h3>
    </div>
    <div>        <form action="{{ route('admin.comentarios') }}" method="GET" class="flex items-center">
            <div class="relative">
                <input type="text" name="search" placeholder="Pesquisar comentários..." class="border rounded-l px-4 py-2 focus:outline-none focus:ring-1 focus:ring-purple-500" value="{{ request('search') }}">
                @if(request('search'))
                    <a href="{{ route('admin.comentarios') }}" class="absolute right-2 top-2.5 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
            <button type="submit" class="bg-purple-600 text-white rounded-r px-4 py-2 hover:bg-purple-700">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

@if(request('search'))
    <div class="mb-4 bg-blue-50 p-3 rounded-md flex justify-between items-center">
        <div>
            A mostrar resultados para: <strong>{{ request('search') }}</strong>
            <span class="text-gray-600">({{ $comentarios->total() }} encontrados)</span>
        </div>
        <a href="{{ route('admin.comentarios') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-times-circle"></i> Limpar filtro
        </a>
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conteúdo</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artigo</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($comentarios as $comentario)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ Str::limit($comentario->conteudo, 100) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $comentario->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $comentario->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <a href="{{ route('artigos.show', $comentario->artigo->id) }}" class="text-blue-600 hover:text-blue-900" target="_blank">
                                {{ Str::limit($comentario->artigo->titulo, 50) }}
                            </a>
                        </div>
                        <div class="text-xs text-gray-500">
                            Categoria: {{ ucfirst($comentario->artigo->categoria) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $comentario->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('artigos.show', $comentario->artigo->id) }}" class="text-blue-600 hover:text-blue-900" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.comentarios.destroy', $comentario->id) }}" method="POST" onsubmit="return confirm('Tens a certeza que queres eliminar este comentário? Esta ação não pode ser revertida.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Nenhum comentário encontrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $comentarios->links() }}
</div>
@endsection
