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

            <!-- Dropdown de Filtros -->
            <div id="filter-dropdown" class="hidden absolute mt-2 bg-white text-black rounded-lg shadow-lg p-4 w-56">
                <label class="block mb-2">
                    <span class="text-gray-700">Categoria:</span>
                    <select class="w-full border border-gray-300 rounded p-2">
                        <option>Tecnologia</option>
                        <option>Ciência</option>
                        <option>Arte</option>
                        <option>Saúde</option>
                    </select>
                </label>
                <label class="block mb-2">
                    <span class="text-gray-700">Data:</span>
                    <input type="date" class="w-full border border-gray-300 rounded p-2">
                </label>
                <button class="w-full bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
                    Aplicar Filtros
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById("filter-btn").addEventListener("click", function() {
        document.getElementById("filter-dropdown").classList.toggle("hidden");
    });
</script>




<!-- Lista de Artigos -->
<section class="bg-white mt-16 py-10 px-6">
    <div class="container mx-auto grid gap-10">
        @forelse ($artigos as $artigo)
        <article class="flex flex-col md:flex-row {{ $loop->iteration % 2 == 0 ? 'md:flex-row-reverse' : '' }} bg-white shadow-md rounded-lg p-6">
            <div class="flex-1">
                <div class="flex items-center space-x-2">
                    <span class="bg-purple-700 text-white px-3 py-1 rounded-full text-sm">
                        {{ $artigo->autor ?? 'Anónimo' }}
                    </span>
                </div>
                <h2 class="text-2xl font-bold mt-2">{{ $artigo->titulo }}</h2>
                <p class="text-gray-600 mt-2">{{ Str::limit(strip_tags($artigo->conteudo), 120) }}</p>
                <a href="{{ route('artigos.show', $artigo->id) }}" class="bg-purple-600 text-white px-4 py-2 mt-4 inline-block rounded-md hover:bg-purple-700 transition">LER MAIS</a>
            </div>
            <img src="{{ asset('icones/artigo' . ($loop->iteration % 4 + 1) . '.jpeg') }}" class="w-60 h-40 object-cover rounded-lg {{ $loop->iteration % 2 == 0 ? 'mr-6' : 'ml-6' }}">
        </article>
        @empty
        <p class="text-gray-600">Nenhum artigo foi publicado ainda.</p>
        @endforelse
    </div>
</section>


@endsection