@extends('layouts.app')

@section('title', 'Publicar Artigo - Post.it')
@vite('resources/css/app.css')

@section('content')
<section class="bg-purple-700 text-white py-16 shadow-md">
    <div class="container mx-auto px-6">
        <h1 class="text-5xl font-bold mb-4 leading-tight">Partilha artigos<br> com o mundo!</h1>
        <p class="text-xl mb-6">Elabora o teu artigo e pensamentos com as outras pessoas.</p>
</section>

<div class="max-w-4xl mx-auto py-10 px-6 bg-white">

    <form action="{{ route('artigos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Título -->
        <div>
            <label class="font-bold text-lg block">Título:</label>
            <input type="text" name="titulo" required
                class="w-full mt-1 bg-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-500"
                placeholder="Escreve o título do teu artigo.">
        </div>

        <!-- Subtítulo -->
        <div>
            <label class="font-bold text-lg block">Subtítulo:</label>
            <input type="text" name="subtitulo"
                class="w-full mt-1 bg-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-500"
                placeholder="Assunto do artigo (opcional).">
        </div>

        <!-- Categoria -->
        <div>
            <label class="font-bold text-lg block">Categoria:</label>
            <select name="categoria"
                class="w-[160px] mt-1 bg-gray-200 rounded-lg px-4 py-3 text-gray-800">
                <option disabled selected>Seleciona</option>
                <option value="tecnologia">Tecnologia</option>
                <option value="ambiente">Ambiente</option>
                <option value="educacao">Educação</option>
                <option value="outros">Outros</option>
            </select>
        </div>



        <!-- Editor de texto com formatação -->
        <div id="editor"
            contenteditable="true"
            class="w-full mt-1 bg-gray-200 rounded-lg px-4 py-3 text-gray-800 h-60 overflow-y-auto">
            Escreve o teu artigo aqui...
        </div>

        <!-- Barra de ferramentas -->
        <div class="flex space-x-3 mt-2 text-gray-600">
            <button type="button" onclick="execCmd('insertImage', prompt('URL da imagem:'))" title="Adicionar imagem">🖼️</button>
            <button type="button" onclick="execCmd('italic')" class="italic" title="Itálico">I</button>
            <button type="button" onclick="execCmd('bold')" class="font-bold" title="Negrito">B</button>
        </div>



        <!-- Botão Publicar -->
        <div class="text-right">
            <button type="submit"
                class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-full transition">
                Publicar
            </button>
        </div>
        <input type="hidden" name="conteudo" id="conteudo-hidden">
    </form>
</div>

<script>
    function execCmd(command, value = null) {
        document.execCommand(command, false, value);
    }

    // Ao submeter o formulário, copia o conteúdo do editor para o input escondido
    document.querySelector('form').addEventListener('submit', function () {
        document.getElementById('conteudo-hidden').value = document.getElementById('editor').innerHTML;
    });
</script>

@endsection
