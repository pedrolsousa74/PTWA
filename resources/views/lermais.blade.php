@extends('layouts.app')

@section('title', $artigo->titulo . ' - Post.it')
@vite('resources/css/app.css')

@section('content')

<section class="bg-purple-700 text-white py-16 shadow-md">
    <div class="container mx-auto px-6">
        <h1 class="text-5xl font-bold mb-2">{{ $artigo->titulo }}</h1>
        @if($artigo->subtitulo)
            <p class="text-2xl mb-4">{{ $artigo->subtitulo }}</p>
        @endif
        <p class="text-sm opacity-80">Publicado a {{ $artigo->created_at->format('d/m/Y') }} na categoria <span class="font-semibold">{{ ucfirst($artigo->categoria) }}</span></p>
    </div>
</section>

<div class="max-w-4xl mx-auto bg-white py-10 px-6">
    <div class="prose max-w-none text-gray-800">
        {!! $artigo->conteudo !!}
    </div>

    <!-- Separação visual com margem e linha -->
    <h3 class="font-semibold mt-10 pt-4 border-t border-gray-200">Comentários:</h3>

    <form action="{{ route('comentarios.store', $artigo->id) }}" method="POST" class="flex space-x-2 mt-2 w-full">
        @csrf
        <textarea name="conteudo" rows="1" placeholder="Escreve um comentário..." class="flex-1 border p-2 rounded resize-none"></textarea>
        <button type="submit" class="bg-purple-600 text-white px-3 py-2 rounded hover:bg-purple-700">Comentar</button>
    </form>

    <div class="mt-4">
        @foreach ($artigo->comentarios as $comentario)
            <div class="text-sm text-gray-700 mt-2 border p-2 rounded bg-gray-100">
                <strong>{{ $comentario->user->name }}</strong>: {{ $comentario->conteudo }}
            </div>
        @endforeach
    </div>




    <div class="mt-10 text-right">
        <a href="{{ route('artigos') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full transition">
            ← Voltar à lista
        </a>
    </div>
</div>

@endsection
