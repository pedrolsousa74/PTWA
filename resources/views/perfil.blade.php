@extends('layouts.app')

@section('title', 'O Meu Perfil - Post.it')
@vite('resources/css/app.css')

@section('content')
<div class="bg-purple-700 py-12 px-6">
    <div class="bg-white max-w-5xl mx-auto rounded-xl shadow-lg p-8">
        <!-- Mensagens de sucesso ou erro -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <!-- Secção do perfil -->
        <div class="flex items-center space-x-8">
            <!-- Ícone/avatar -->
            <div class="w-32 h-32 bg-gray-300 rounded-full flex items-center justify-center text-5xl text-purple-700">
                👤
            </div>

            <!-- Dados do utilizador -->
            <div>
                <h2 class="text-3xl font-bold text-purple-700 mb-2">{{ Auth::user()->name }}</h2>
                <p class="text-gray-600"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p class="text-gray-600"><strong>Conta criada em:</strong> {{ Auth::user()->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Botões Agrupados como se fosse um só -->
<div class="max-w-5xl mx-auto px-6 py-6 text-center mb-6">
    <div class="inline-flex rounded-lg overflow-hidden shadow-md w-full">
        <button id="meusArtigosBtn" class="px-6 py-3 text-white w-full text-center focus:outline-none transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 border-r-2 border-purple-500 bg-purple-600 hover:bg-purple-700"
            onclick="toggleContent('meusArtigos')">
            Meus Artigos
        </button>
        <button id="favoritosBtn" class="px-6 py-3 text-white w-full text-center focus:outline-none transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 bg-purple-600 hover:bg-purple-700"
            onclick="toggleContent('favoritos')">
            Favoritos
        </button>
    </div>
</div>



<!-- Seção de Artigos -->
<div id="meusArtigos" class="max-w-5xl mx-auto px-6 py-10">
    <h3 class="text-2xl font-bold text-purple-700 mb-6">Os Meus Artigos</h3>    @forelse(Auth::user()->artigos()->latest()->get() as $artigo)
        <div class="bg-white rounded-md shadow p-6 mb-4">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-xl font-semibold text-gray-800">{{ $artigo->titulo }}</h4>
                    <p class="text-gray-600 mt-2">{{ Str::limit(strip_tags($artigo->conteudo), 150) }}</p>                    <a href="{{ route('artigos.show', $artigo->id) }}" class="text-purple-600 font-semibold hover:underline mt-2 inline-block">
                        Ler mais →
                    </a>
                </div>
                <div class="flex space-x-2">
                    <!-- Botão de Editar -->
                    <a href="{{ route('artigos.edit', $artigo->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition duration-300 ease-in-out transform hover:scale-105 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>
                    
                    <!-- Botão de Excluir -->
                    <form action="{{ route('artigos.destroy', $artigo->id) }}" method="POST" onsubmit="return confirm('Tens a certeza que pretendes apagar este artigo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition duration-300 ease-in-out transform hover:scale-105 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-600">Ainda não escreveste nenhum artigo.</p>
    @endforelse
</div>

<!-- Seção de Artigos Favoritos -->
<div id="favoritos" class="max-w-5xl mx-auto px-6 py-10 hidden">
    <h3 class="text-2xl font-bold text-purple-700 mb-6">Artigos Favoritos</h3>

    @forelse(Auth::user()->artigosFavoritos()->latest()->get() as $artigo)
        <div class="bg-white rounded-md shadow p-6 mb-4">
            <h4 class="text-xl font-semibold text-gray-800">{{ $artigo->titulo }}</h4>
            <p class="text-gray-600 mt-2">{{ Str::limit(strip_tags($artigo->conteudo), 150) }}</p>

            <a href="{{ route('artigos.show', $artigo->id) }}" class="text-purple-600 font-semibold hover:underline mt-2 inline-block">
                Ler mais →
            </a>
        </div>
    @empty
        <p class="text-gray-600">Ainda não marcaste nenhum artigo como favorito.</p>
    @endforelse
</div>

@endsection

@section('scripts')
<script>
    // Função para alternar entre as seções
    function toggleContent(section) {
        // Esconde todas as seções
        document.getElementById('meusArtigos').classList.add('hidden');
        document.getElementById('favoritos').classList.add('hidden');

        // Exibe a seção desejada
        if (section === 'meusArtigos') {
            document.getElementById('meusArtigos').classList.remove('hidden');
            // Adiciona a classe 'active' no botão "Meus Artigos"
            document.getElementById('meusArtigosBtn').classList.add('bg-purple-800', 'text-white');
            document.getElementById('favoritosBtn').classList.remove('bg-purple-800', 'text-white');
        } else if (section === 'favoritos') {
            document.getElementById('favoritos').classList.remove('hidden');
            // Adiciona a classe 'active' no botão "Favoritos"
            document.getElementById('favoritosBtn').classList.add('bg-purple-800', 'text-white');
            document.getElementById('meusArtigosBtn').classList.remove('bg-purple-800', 'text-white');
        }
    }

    // Exibe "Meus Artigos" por padrão ao carregar a página
    window.onload = function() {
        toggleContent('meusArtigos');
    };
</script>
@endsection
