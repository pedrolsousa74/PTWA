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

        <!-- Artigo 1 -->
        <article class="flex flex-col md:flex-row bg-white shadow-md rounded-lg p-6">
            <div class="flex-1">
                <div class="flex items-center space-x-2">
                    <span class="bg-purple-700 text-white px-3 py-1 rounded-full text-sm">João Silva</span>
                </div>
                <h2 class="text-2xl font-bold mt-2">A Inteligência Artificial vai mudar o mundo? Descobre como!</h2>
                <p class="text-gray-600 mt-2">A Inteligência Artificial está a transformar a forma como trabalhamos, comunicamos e até criamos arte...</p>
                <button class="bg-purple-600 text-white px-4 py-2 mt-4 rounded-md">LER MAIS</button>
            </div>
            <img src="{{ asset('icones/artigo1.jpg') }}" class="w-60 h-40 object-cover rounded-lg ml-6">
        </article>

        <!-- Artigo 2 -->
        <article class="flex flex-col md:flex-row-reverse bg-white shadow-md rounded-lg p-6">
            <div class="flex-1">
                <div class="flex items-center space-x-2">
                    <span class="bg-purple-700 text-white px-3 py-1 rounded-full text-sm">Rute Palmeirim</span>
                </div>
                <h2 class="text-2xl font-bold mt-2">Como a natureza se está a desgastar?</h2>
                <p class="text-gray-600 mt-2">A exploração contínua dos recursos naturais tem causado grandes impactos ambientais...</p>
                <button class="bg-purple-600 text-white px-4 py-2 mt-4 rounded-md">LER MAIS</button>
            </div>
            <img src="{{ asset('icones/artigo2.jpeg') }}" class="w-60 h-40 object-cover rounded-lg mr-6">
        </article>

        <!-- Artigo 3 -->
        <article class="flex flex-col md:flex-row bg-white shadow-md rounded-lg p-6">
            <div class="flex-1">
                <div class="flex items-center space-x-2">
                    <span class="bg-purple-700 text-white px-3 py-1 rounded-full text-sm">João Silva</span>
                </div>
                <h2 class="text-2xl font-bold mt-2">A Inteligência Artificial vai mudar o mundo? Descobre como!</h2>
                <p class="text-gray-600 mt-2">A Inteligência Artificial está a transformar a forma como trabalhamos, comunicamos e até criamos arte...</p>
                <button class="bg-purple-600 text-white px-4 py-2 mt-4 rounded-md">LER MAIS</button>
            </div>
            <img src="{{ asset('icones/artigo3.png') }}" class="w-60 h-40 object-cover rounded-lg ml-6">
        </article>

        <!-- Artigo 4 -->
        <article class="flex flex-col md:flex-row-reverse bg-white shadow-md rounded-lg p-6">
            <div class="flex-1">
                <div class="flex items-center space-x-2">
                    <span class="bg-purple-700 text-white px-3 py-1 rounded-full text-sm">Rute Palmeirim</span>
                </div>
                <h2 class="text-2xl font-bold mt-2">Como a natureza se está a desgastar?</h2>
                <p class="text-gray-600 mt-2">A exploração contínua dos recursos naturais tem causado grandes impactos ambientais...</p>
                <button class="bg-purple-600 text-white px-4 py-2 mt-4 rounded-md">LER MAIS</button>
            </div>
            <img src="{{ asset('icones/artigo4.jpeg') }}" class="w-60 h-40 object-cover rounded-lg mr-6">
        </article>

    </div>
</section>

@endsection