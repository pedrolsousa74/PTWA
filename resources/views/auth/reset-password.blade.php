@extends('layouts.auth')

@section('title', 'Redefinir Senha - Post.it')

@section('content')
<div class="flex items-center justify-center min-h-screen relative">
    
    <!-- Logo "POST-IT" no canto superior esquerdo -->
    <h1 class="absolute top-4 left-4 text-xl font-bold text-white">POST-IT</h1>

    <div class="w-full max-w-md text-center text-white">
        <!-- Título -->
        <h2 class="text-4xl font-extrabold mt-10">Redefinir Senha</h2>
        
        <!-- Descrição -->
        <p class="mt-4 text-gray-300">
            Crie uma nova senha para a sua conta.
        </p>

        <!-- Erros de validação -->
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <!-- Formulário -->
        <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-4">
            @csrf

            <!-- Token oculto -->
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="text-left">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', request()->email) }}" required
                    class="w-full px-4 py-3 mt-1 bg-gray-300 rounded-lg focus:outline-none text-black">
            </div>

            <div class="text-left">
                <label class="block text-sm font-medium">Nova Senha</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 mt-1 bg-gray-300 rounded-lg focus:outline-none text-black">
            </div>

            <div class="text-left">
                <label class="block text-sm font-medium">Confirmar Nova Senha</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-3 mt-1 bg-gray-300 rounded-lg focus:outline-none text-black">
            </div>

            <!-- Botão de Redefinir -->
            <button type="submit"
                class="w-full mt-4 bg-gray-300 text-purple-700 font-bold py-3 rounded-lg hover:bg-gray-400 transition">
                Redefinir Senha
            </button>
        </form>

        <!-- Links de navegação -->
        <div class="mt-6">
            <a href="{{ route('login') }}" class="text-white font-semibold hover:underline">
                Voltar ao login
            </a>
        </div>
    </div>
</div>
@endsection