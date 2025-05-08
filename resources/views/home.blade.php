@extends('layouts.app')

@section('title', 'Post.it - Ideias que Inspiram')
@vite('resources/css/app.css')

@section('content')
    <!-- Hero Section -->
    <section class="bg-purple-700 text-white py-16 shadow-md">
        <div class="container mx-auto flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 text-left">
                <h2 class="text-5xl font-bold mb-4 leading-tight">
                    Descobre as ideias que estão a inspirar o mundo.
                </h2>
                <p class="text-xl mb-6">Os melhores artigos do momento.</p>
                <button onclick="window.location.href='{{ route('artigos') }}'" class="bg-yellow-500 text-black px-6 py-3 rounded-md text-lg font-semibold hover:bg-yellow-600 transition">
                    VER ARTIGOS
                </button>
            </div>
            <div class="lg:w-1/2 flex justify-end">
                <img src="{{ asset('icones/Lampada.webp') }}" alt="Ideias" class="w-40 lg:w-64">
            </div>
        </div>
    </section>

    <!-- Tendências -->
    <section class="tendencias py-16 px-6 bg-purple-700 text-white">
        <div class="container mx-auto text-center">
            <h2 class="text-5xl font-bold mb-10">Tendências</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @php
                    $imagens = ['artigo1.jpg', 'artigo2.jpeg', 'artigo3.png', 'artigo4.jpeg'];
                @endphp
                @foreach ($imagens as $index => $imagem)
                    <div class="bg-white text-gray-900 p-6 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-2">
                        <img src="{{ asset('icones/' . $imagem) }}" alt="Imagem do Artigo {{ $index + 1 }}" class="w-full h-40 object-cover rounded-md mb-4">
                        <h3 class="text-xl font-semibold">Título do Artigo {{ $index + 1 }}</h3>
                        <p class="text-gray-600 mt-2">Este é um pequeno resumo do artigo {{ $index + 1 }} para despertar interesse no leitor.</p>
                        <a href="#" class="mt-4 inline-block bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-800 transition">
                            Ler Mais
                        </a>
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
    <section class="criar-conta text-center py-32 bg-purple-700 flex justify-center items-center">
        <div class="bg-yellow-500 text-white w-full max-w-6xl h-72 rounded-lg shadow-lg flex flex-col justify-center items-center">
            <h2 class="text-4xl font-bold mb-6 text-center leading-snug">
                Cria conta e começa a publicar
            </h2>
            <button onclick="window.location.href='{{ route('register') }}'" class="bg-purple-700 text-white px-8 py-4 rounded-md text-lg font-semibold hover:bg-purple-800 transition">
                CRIAR CONTA
            </button>
        </div>
    </section>




    
@endsection
