@extends('layouts.app') {{-- Ou layouts.main, conforme o teu layout principal --}}

@section('title', 'O Meu Perfil - Post.it')
@vite('resources/css/app.css')

@section('content')
<div class="bg-purple-700 py-12 px-6">
    <div class="bg-white max-w-5xl mx-auto rounded-xl shadow-lg p-8">
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

<!-- Lista de artigos -->
<div class="max-w-5xl mx-auto px-6 py-10">
    <h3 class="text-2xl font-bold text-purple-700 mb-6">Os Meus Artigos</h3>

    @forelse(Auth::user()->artigos()->latest()->get() as $artigo)
        <div class="bg-white rounded-md shadow p-6 mb-4">
            <h4 class="text-xl font-semibold text-gray-800">{{ $artigo->titulo }}</h4>
            <p class="text-gray-600 mt-2">{{ Str::limit($artigo->conteudo, 150) }}</p>
            <a href="{{ route('artigos.show', $artigo->id) }}" class="text-purple-600 font-semibold hover:underline mt-2 inline-block">
                Ler mais →
            </a>
        </div>
    @empty
        <p class="text-gray-600">Ainda não escreveste nenhum artigo.</p>
    @endforelse

</div>
@endsection
