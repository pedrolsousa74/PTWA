@extends('layouts.app')

@section('title', 'Post.it - Ideias que Inspiram')
@vite('resources/css/app.css')

@section('content')
    <!-- Hero Section -->
    <section class="hero bg-purple-700 text-white py-16 px-6 relative">
        <div class="container mx-auto flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 text-left">
                <h2 class="text-5xl font-bold mb-4 leading-tight">
                    Descobre as ideias que estão a inspirar o mundo.
                </h2>
                <p class="text-xl mb-6">Os melhores artigos do momento.</p>
                <button class="bg-yellow-500 text-black px-6 py-3 rounded-md text-lg font-semibold hover:bg-yellow-600 transition">
                    VER ARTIGOS
                </button>
            </div>
            <div class="lg:w-1/2 flex justify-end">
                <img src="{{ asset('icones/Lampada.webp') }}" alt="Ideias" class="w-40 lg:w-64">
            </div>
        </div>
    </section>

    <!-- Tendências -->
    <section class="tendencias py-16 px-6 bg-gray-800 text-white">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-8">Tendências</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @foreach (range(1, 4) as $i)
                    <div class="card bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition text-black">
                        <h3 class="text-xl font-semibold">Título do Artigo {{ $i }}</h3>
                        <p class="text-gray-600 mt-2">Descrição do artigo {{ $i }}.</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Escrever Artigo -->
    <section class="escrever bg-purple-700 text-white py-16 px-6">
        <div class="container mx-auto flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 flex justify-start">
                <img src="{{ asset('icones/escrever.webp') }}" alt="Escrever artigo" class="w-40 lg:w-64">
            </div>
            <div class="lg:w-1/2 text-left">
                <h2 class="text-5xl font-bold mb-4 leading-tight">Tens algo a dizer? Começa a escrever!</h2>
                <p class="text-xl mb-6">Transforma os teus pensamentos em palavras. Publica já!</p>
                <button class="bg-yellow-500 text-black px-6 py-3 rounded-md text-lg font-semibold hover:bg-yellow-600 transition">
                    PUBLICAR
                </button>
            </div>
        </div>
    </section>

    <!-- Criar Conta -->
    <section class="criar-conta text-center py-16 bg-yellow-500 text-black">
        <h2 class="text-3xl font-bold mb-4">Cria conta e começa a publicar</h2>
        <button class="bg-purple-700 text-white px-6 py-3 rounded-md text-lg font-semibold hover:bg-purple-800 transition">
            CRIAR CONTA
        </button>
    </section>

    
@endsection
