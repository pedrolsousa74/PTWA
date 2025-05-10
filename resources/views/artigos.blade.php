@extends('layouts.app')

@section('title', 'Post.it - Ideias que Inspiram')
@vite('resources/css/app.css')

@section('content')

<section class="bg-purple-700 text-white py-16 shadow-md">
    <div class="container mx-auto px-6">
        <h1 class="text-5xl font-bold mb-4 leading-tight">Explora os <br> melhores artigos!</h1>
        <p class="text-xl mb-6">Descobre opiniões, histórias e tendências aqui.</p>

        <!-- Botão Filtrar -->
        <div class="relative mt-4">
            <button id="filter-btn" class="bg-yellow-500 text-black px-6 py-3 rounded-md text-lg font-semibold hover:bg-yellow-600 transition">
                FILTRAR
            </button>

            <!-- Formulário de Filtro -->
            <form method="GET" action="{{ route('artigos') }}">
                <div id="filter-dropdown" class="hidden absolute mt-2 bg-white text-black rounded-lg shadow-lg p-4 w-64 z-10">
                    <label class="block mb-2">
                        <span class="text-gray-700">Categoria:</span>
                        <select name="categoria" class="w-full border border-gray-300 rounded p-2">
                            <option value="">Todas</option>
                            <option value="tecnologia" {{ request('categoria') == 'tecnologia' ? 'selected' : '' }}>Tecnologia</option>
                            <option value="ambiente" {{ request('categoria') == 'ambiente' ? 'selected' : '' }}>Ambiente</option>
                            <option value="educacao" {{ request('categoria') == 'educacao' ? 'selected' : '' }}>Educação</option>
                            <option value="outros" {{ request('categoria') == 'outros' ? 'selected' : '' }}>Outros</option>
                        </select>
                    </label>
                    <label class="block mb-2">
                        <span class="text-gray-700">Data:</span>
                        <input type="date" name="data" value="{{ request('data') }}" class="w-full border border-gray-300 rounded p-2">
                    </label>
                    <button type="submit" class="w-full bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
                        Aplicar Filtros
                    </button>
                </div>
            </form>



        </div>
    </div>
</section>

<script>
    document.getElementById("filter-btn").addEventListener("click", function () {
        document.getElementById("filter-dropdown").classList.toggle("hidden");
    });
</script>

<!-- Lista de Artigos -->
<section class="bg-white mt-16 py-10 px-6">
    <div class="container mx-auto grid gap-10">
        @forelse ($artigos as $artigo)
        <article class="flex flex-col md:flex-row {{ $loop->iteration % 2 == 0 ? 'md:flex-row-reverse' : '' }} bg-white shadow-md rounded-lg p-6">
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <span class="bg-purple-700 text-white px-3 py-1 rounded-full text-sm">
                        {{ $artigo->user->name ?? 'Anónimo' }}
                    </span>

                </div>

                <h2 class="text-2xl font-bold mt-2">{{ $artigo->titulo }}</h2>
                <p class="text-gray-600 mt-2">{{ Str::limit(strip_tags($artigo->conteudo), 120) }}</p>
                
                <div class="flex items-center space-x-4 mt-4">
                    <a href="{{ route('artigos.show', $artigo->id) }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
                        LER MAIS
                    </a>

                    <form action="{{ route('artigos.like', $artigo->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 text-xl">
                            @if ($artigo->usersWhoLiked->contains(auth()->user()))
                                <i class="fas fa-heart"></i>
                            @else
                                <i class="far fa-heart"></i>
                            @endif
                            <span class="text-sm text-black ml-1">{{ $artigo->usersWhoLiked->count() }}</span>
                        </button>
                    </form>
                </div>

            </div>
            <img src="{{ asset('icones/artigo' . ($loop->iteration % 4 + 1) . '.jpeg') }}" class="w-60 h-40 object-cover rounded-lg {{ $loop->iteration % 2 == 0 ? 'mr-6' : 'ml-6' }}">
        </article>
        @empty
        <p class="text-gray-600">Nenhum artigo foi publicado ainda.</p>
        @endforelse
    </div>
</section>


@endsection
