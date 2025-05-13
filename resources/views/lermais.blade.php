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
    </div>    <!-- Separação visual com margem e linha -->
    <h3 class="font-semibold mt-10 pt-4 border-t border-gray-200">Comentários ({{ $artigo->comentarios->count() }}):</h3>

    @auth
    <form action="{{ route('comentarios.store', $artigo->id) }}" method="POST" class="flex space-x-2 mt-2 w-full">
        @csrf
        <textarea name="conteudo" rows="2" placeholder="Escreve um comentário..." class="flex-1 border p-2 rounded resize-none"></textarea>
        <button type="submit" class="bg-purple-600 text-white px-3 py-2 rounded hover:bg-purple-700">Comentar</button>
    </form>
    @else
    <div class="bg-gray-100 p-4 rounded mt-2 text-center">
        <a href="{{ route('login') }}" class="text-purple-600 hover:underline">Entra na tua conta</a> ou 
        <a href="{{ route('register') }}" class="text-purple-600 hover:underline">regista-te</a> para comentar.
    </div>
    @endauth

    <div class="mt-6">
        @if ($artigo->comentarios->count() > 0)
            @foreach ($artigo->comentarios()->with('user')->latest()->get() as $comentario)
                <div class="mb-4 bg-white border shadow-sm rounded-lg overflow-hidden">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="font-semibold text-purple-800">{{ $comentario->user->name }}</span>
                                <span class="text-xs text-gray-500 ml-2">{{ $comentario->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            
                            @auth
                                @if (auth()->user()->id === $comentario->user_id || auth()->user()->isAdmin())
                                    <form action="{{ route('comentarios.destroy', $comentario->id) }}" method="POST" onsubmit="return confirm('Tens a certeza que desejas eliminar este comentário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        <p class="text-gray-800">{{ $comentario->conteudo }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-8 text-gray-500">
                Nenhum comentário ainda. Seja o primeiro a comentar!
            </div>
        @endif
    </div>




    <div class="mt-10 text-right">
        <a href="{{ route('artigos') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full transition">
            ← Voltar à lista
        </a>
    </div>
</div>

@endsection
