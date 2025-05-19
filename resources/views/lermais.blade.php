@extends('layouts.app')

@section('title', $artigo->titulo . ' - Post.it')
@vite('resources/css/app.css')

<style>
    .article-image-sticky {
        position: sticky;
        top: 100px;
        align-self: flex-start;
    }
</style>

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

<!-- Calculamos a imagem do artigo -->
@php
    // Use post-it.png como imagem padrão
    $defaultImage = 'Icones/post-it.png';
    
    // Primary path - check both possible paths
    $imagePath = null;
    
    if ($artigo->imagem) {
        $publicPath = public_path('storage/artigos/' . $artigo->imagem);
        $storagePath = storage_path('app/public/artigos/' . $artigo->imagem);
        $directPath = public_path('artigos/' . $artigo->imagem);
        
        if (file_exists($publicPath)) {
            $imagePath = asset('storage/artigos/' . $artigo->imagem);
        } elseif (file_exists($storagePath)) {
            $imagePath = asset('storage/artigos/' . $artigo->imagem);
        } elseif (file_exists($directPath)) {
            $imagePath = asset('artigos/' . $artigo->imagem);
        } else {
            $imagePath = asset($defaultImage);
        }
    } else {
        $imagePath = asset($defaultImage);
    }
@endphp

<!-- Layout com conteúdo centralizado na página inteira e imagem à esquerda -->
<div class="bg-white py-10 px-4">
    <div class="container mx-auto relative">
        <!-- Layout em duas partes -->
        <div class="flex flex-col lg:flex-row relative">
            <!-- Coluna da esquerda (imagem) - versão desktop -->
            <div class="hidden lg:block lg:w-1/6 xl:w-1/6 absolute left-0 top-0">
                <div class="article-image-sticky pr-4">
                    <img src="{{ $imagePath }}" alt="Imagem do artigo" class="w-full rounded-lg shadow-md" 
                        onerror="this.onerror=null; this.src='{{ asset('Icones/post-it.png') }}';">
                </div>
            </div>
            
            <!-- Imagem para dispositivos móveis (centralizada no topo) -->
            <div class="block lg:hidden mx-auto mb-8 max-w-xs">
                <img src="{{ $imagePath }}" alt="Imagem do artigo" class="w-full rounded-lg shadow-md" 
                    onerror="this.onerror=null; this.src='{{ asset('Icones/post-it.png') }}';">
            </div>
            
            <!-- Conteúdo principal centralizado na página inteira -->
            <div class="w-full flex justify-center">
                <!-- Este container mantém o conteúdo centralizado com largura limitada -->
                <div class="w-full max-w-2xl mx-auto">
                    <div class="prose max-w-none text-gray-800">
                        {!! $artigo->conteudo !!}
                    </div>
                    
                    <!-- Separação visual com margem e linha -->
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
                    </div>                    <div class="mt-10 flex justify-center">
                        <a href="{{ route('artigos') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full transition">
                            ← Voltar à lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
