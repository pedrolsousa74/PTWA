@extends('layouts.auth')

@section('title', 'Iniciar Sessão - Post.it')

@section('content')
<div class="flex items-center justify-center min-h-screen relative">
    
    <!-- Logo "POST-IT" no canto superior esquerdo -->
    <h1 class="absolute top-4 left-4 text-xl font-bold text-white">POST-IT</h1>

    <div class="w-full max-w-md text-center text-white">
        <!-- Título -->
        <h2 class="text-4xl font-extrabold mt-10">Iniciar sessão</h2>

        <!-- Formulário -->
        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf

            <div class="text-left">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-3 mt-1 bg-gray-300 rounded-lg focus:outline-none text-black">
            </div>

            <div class="text-left">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 mt-1 bg-gray-300 rounded-lg focus:outline-none text-black">
            </div>

            <!-- Botão de Login -->
            <button type="submit"
                class="w-full mt-4 bg-gray-300 text-purple-700 font-bold py-3 rounded-lg hover:bg-gray-400 transition">
                Entrar
            </button>
        </form>

        <!-- Botão "Continuar como leitor" -->
        <button onclick="window.location.href='{{ route('home') }}'"
            class="w-full mt-4 bg-gray-300 text-purple-700 font-bold py-3 rounded-lg hover:bg-gray-400 transition">
            Continuar como leitor
        </button>

        <!-- Link para registo -->
        <p class="mt-4">
            <a href="{{ route('register') }}" class="text-white font-semibold hover:underline">
                Ainda não tens conta?
            </a>
        </p>
    </div>
</div>
@endsection
