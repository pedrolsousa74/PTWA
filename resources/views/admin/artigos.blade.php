@extends('layouts.admin')

@section('title', 'Gerir Artigos')

@section('page-title', 'Gerir Artigos')

@section('content')
<!-- Formulário de pesquisa -->
<div class="mb-6">
    <form action="{{ route('admin.artigos') }}" method="GET" class="flex">
        <div class="relative flex-grow">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Pesquisar por título, conteúdo ou autor..." 
                   class="w-full px-4 py-2 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
            @if(isset($search) && !empty($search))
                <a href="{{ route('admin.artigos') }}" class="absolute right-2 top-2 text-gray-500 hover:text-gray-700">
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
        <span class="text-gray-600">({{ $artigos->total() }} encontrados)</span>
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($artigos as $artigo)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $artigo->titulo }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $artigo->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $artigo->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                            {{ ucfirst($artigo->categoria) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $artigo->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('artigos.show', $artigo->id) }}" class="text-blue-600 hover:text-blue-900" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.artigos.destroy', $artigo->id) }}" method="POST" onsubmit="return confirm('Tens a certeza que queres eliminar este artigo? Esta ação não pode ser revertida.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $artigos->links() }}
</div>
@endsection
