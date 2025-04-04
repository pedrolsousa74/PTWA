@extends('layouts.app')

@section('title', 'Post.it - Ideias que Inspiram')
@vite('resources/css/app.css')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-purple-700">
    <div class="w-full max-w-md text-center text-white">
        <!-- Logo -->
        <h1 class="text-xl font-bold text-left">POST-IT</h1>

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
                class="w-full mt-4 bg-white text-purple-700 font-bold py-3 rounded-lg hover:bg-gray-200 transition">
                Entrar
            </button>
        </form>
    </div>
</div>
@endsection
