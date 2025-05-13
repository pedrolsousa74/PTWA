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
    @if(isset($artigo))
        <h2 class="text-3xl font-bold mb-6 text-purple-700">Editar Artigo</h2>
        <form id="artigo-form" action="{{ route('artigos.update', $artigo->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
    @else
        <h2 class="text-3xl font-bold mb-6 text-purple-700">Criar Novo Artigo</h2>
        <form id="artigo-form" action="{{ route('artigos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
    @endif

        <!-- Título -->
        <div>
            <label class="font-bold text-lg block">Título:</label>
            <input type="text" name="titulo" required
                class="w-full mt-1 bg-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-500"
                placeholder="Escreve o título do teu artigo."
                value="{{ isset($artigo) ? $artigo->titulo : old('titulo') }}">
        </div>

        <!-- Subtítulo -->
        <div>
            <label class="font-bold text-lg block">Subtítulo:</label>
            <input type="text" name="subtitulo"
                class="w-full mt-1 bg-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-500"
                placeholder="Assunto do artigo (opcional)."
                value="{{ isset($artigo) ? $artigo->subtitulo : old('subtitulo') }}">
        </div>

        <!-- Categoria -->
        <div>
            <label class="font-bold text-lg block">Categoria:</label>
            <select name="categoria" required
                class="w-[160px] mt-1 bg-gray-200 rounded-lg px-4 py-3 text-gray-800">
                <option disabled {{ !isset($artigo) ? 'selected' : '' }}>Seleciona</option>
                <option value="tecnologia" {{ isset($artigo) && $artigo->categoria == 'tecnologia' ? 'selected' : '' }}>Tecnologia</option>
                <option value="ambiente" {{ isset($artigo) && $artigo->categoria == 'ambiente' ? 'selected' : '' }}>Ambiente</option>
                <option value="educacao" {{ isset($artigo) && $artigo->categoria == 'educacao' ? 'selected' : '' }}>Educação</option>
                <option value="outros" {{ isset($artigo) && $artigo->categoria == 'outros' ? 'selected' : '' }}>Outros</option>
            </select>
        </div>

        <!-- Editor -->
        <div id="editor"
            contenteditable="true"
            class="w-full mt-1 bg-gray-200 rounded-lg px-4 py-3 text-gray-800 h-60 overflow-y-auto border border-gray-300 focus:outline-none">
            {!! isset($artigo) ? $artigo->conteudo : '' !!}
        </div>

        <!-- Botões de formatação -->
        <div class="flex space-x-3 mt-2 text-gray-600">
            <button type="button" onclick="execCmd('bold')" class="font-bold" title="Negrito">B</button>
            <button type="button" onclick="execCmd('italic')" class="italic" title="Itálico">I</button>
            <button type="button" onclick="execCmd('insertImage', prompt('URL da imagem:'))" title="Imagem">🖼️</button>
        </div>

        <!-- Textarea escondida que vai realmente enviar o conteúdo -->
        <textarea name="conteudo" id="conteudo" class="hidden"></textarea>

        <!-- Upload da Imagem -->
        <div>
            <label class="font-bold text-lg block">Imagem de Capa (Opcional):</label>
            <div class="flex items-center mt-1">
                <!-- Botão de escolher ficheiro -->
                <label for="imagem" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-full text-sm cursor-pointer transition">
                    Escolher Ficheiro
                </label>
                <input type="file" id="imagem" name="imagem" accept="image/*" class="hidden">
            </div>
        </div>



        <!-- Botão -->
        <div class="text-right">
            <button type="submit"
                class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-full transition">
                {{ isset($artigo) ? 'Salvar Alterações' : 'Publicar' }}
            </button>
        </div>
    </form>

</div>

<script>
    function execCmd(command, value = null) {
        document.execCommand(command, false, value);
    }

    document.getElementById('artigo-form').addEventListener('submit', function (e) {
        const editorContent = document.getElementById('editor').innerHTML.trim();

        if (!editorContent || editorContent === '<br>' || editorContent === '<div><br></div>') {
            alert('Por favor, escreve algum conteúdo no artigo.');
            e.preventDefault();
            return;
        }

        document.getElementById('conteudo').value = editorContent;
    });
</script>
@endsection
