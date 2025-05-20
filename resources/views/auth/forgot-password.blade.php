@extends('layouts.auth')

@section('title', 'Recuperar Senha - Post.it')

@section('content')
<div class="flex items-center justify-center min-h-screen relative">
    
    <!-- Logo "POST-IT" no canto superior esquerdo -->
    <h1 class="absolute top-4 left-4 text-xl font-bold text-white">POST-IT</h1>

    <div class="w-full max-w-md text-center text-white">
        <!-- Título -->
        <h2 class="text-4xl font-extrabold mt-10">Recuperar Senha</h2>
        
        <!-- Descrição -->
        <p class="mt-4 text-gray-300">
            Insira o seu email para receber um link de recuperação de senha.
        </p>

        <!-- Mensagem de status -->
        @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <!-- Erros de validação -->
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <!-- Formulário -->
        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
            @csrf

            <div class="text-left">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 mt-1 bg-gray-300 rounded-lg focus:outline-none text-black">
            </div>

            <!-- Botão de Enviar -->
            <button type="submit"
                class="w-full mt-4 bg-gray-300 text-purple-700 font-bold py-3 rounded-lg hover:bg-gray-400 transition">
                Enviar link de recuperação
            </button>
        </form>

        <!-- Links de navegação -->
        <div class="mt-6 flex justify-between">
            <a href="{{ route('login') }}" class="text-white font-semibold hover:underline">
                Voltar ao login
            </a>
            <a href="{{ route('register') }}" class="text-white font-semibold hover:underline">
                Registar conta
            </a>
        </div>
    </div>
</div>
@endsection