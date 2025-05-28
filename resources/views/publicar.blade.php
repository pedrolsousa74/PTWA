@extends('layouts.app')

@section('title', 'Publicar Artigo - Post.it')
@vite('resources/css/app.css')

<style>
    .bg-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .animate-fadeIn {
        animation: fadeIn 1s ease-in-out forwards;
    }
    
    .editor-btn {
        @apply rounded-md p-2 transition-colors hover:bg-purple-100;
    }
    
    .editor-btn.active {
        @apply bg-purple-200 text-purple-800;
    }
    
    #editor {
        min-height: 300px;
        transition: all 0.3s ease;
    }
    
    #editor:focus {
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.3);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@section('content')
<!-- Hero Section -->
<section class="bg-purple-700 text-white py-20 shadow-lg relative overflow-hidden">
    <div class="absolute inset-0 bg-pattern opacity-10"></div>
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute w-80 h-80 bg-purple-600 rounded-full opacity-20 top-0 right-20"></div>
        <div class="absolute w-72 h-72 bg-yellow-400 rounded-full opacity-10 top-10 left-0"></div>
        <div class="absolute w-64 h-64 bg-purple-500 rounded-full filter blur-3xl opacity-20 bottom-0 right-10"></div>
    </div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight animate-fadeIn">Partilha as tuas <span class="text-yellow-400">ideias</span><br> com o mundo!</h1>
            <p class="text-xl mb-8 text-gray-200 max-w-lg">Elabora o teu artigo e partilha os teus pensamentos com a comunidade.</p>
        </div>
    </div>
</section>

<!-- Formulário de Publicação -->
<section class="py-16 px-6 bg-white relative">
    <div class="absolute inset-0 bg-pattern opacity-5"></div>
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-8 relative z-10">
        @if(isset($artigo))
            <div class="flex items-center mb-8">
                <div class="bg-purple-100 p-2 rounded-full mr-4">
                    <i class="fas fa-edit text-purple-700 text-xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-purple-900">Editar Artigo</h2>
            </div>
            <form id="artigo-form" action="{{ route('artigos.update', $artigo->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
        @else
            <div class="flex items-center mb-8">
                <div class="bg-purple-100 p-2 rounded-full mr-4">
                    <i class="fas fa-pen-fancy text-purple-700 text-xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-purple-900">Criar Novo Artigo</h2>
            </div>
            <form id="artigo-form" action="{{ route('artigos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
        @endif

            <!-- Título -->
            <div class="mb-6">
                <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-heading mr-1 text-purple-500"></i> Título do Artigo
                </label>
                <input type="text" id="titulo" name="titulo" required
                    class="w-full border border-purple-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    placeholder="Escreve um título cativante para o teu artigo"
                    value="{{ isset($artigo) ? $artigo->titulo : old('titulo') }}">
            </div>

            <!-- Categoria -->
            <div class="mb-6">
                <label for="categoria" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-folder mr-1 text-purple-500"></i> Categoria
                </label>
                <select id="categoria" name="categoria" required
                    class="w-full border border-purple-200 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option disabled {{ !isset($artigo) ? 'selected' : '' }}>Seleciona uma categoria</option>
                    <option value="tecnologia" {{ isset($artigo) && $artigo->categoria == 'tecnologia' ? 'selected' : '' }}>Tecnologia</option>
                    <option value="ambiente" {{ isset($artigo) && $artigo->categoria == 'ambiente' ? 'selected' : '' }}>Ambiente</option>
                    <option value="educacao" {{ isset($artigo) && $artigo->categoria == 'educacao' ? 'selected' : '' }}>Educação</option>
                    <option value="outros" {{ isset($artigo) && $artigo->categoria == 'outros' ? 'selected' : '' }}>Outros</option>
                </select>
            </div>

            <!-- Editor -->
            <div class="mb-6">
                <label for="editor" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-paragraph mr-1 text-purple-500"></i> Conteúdo do Artigo
                </label>
                
                <!-- Barra de ferramentas do editor -->
                <div class="flex flex-wrap gap-1 mb-2 p-2 bg-gray-50 border border-purple-200 rounded-t-lg">
                    <button type="button" onclick="execCmd('bold')" class="editor-btn" title="Negrito">
                        <i class="fas fa-bold"></i>
                    </button>
                    <button type="button" onclick="execCmd('italic')" class="editor-btn" title="Itálico">
                        <i class="fas fa-italic"></i>
                    </button>
                    <button type="button" onclick="execCmd('underline')" class="editor-btn" title="Sublinhado">
                        <i class="fas fa-underline"></i>
                    </button>
                    <div class="w-px h-6 bg-gray-300 mx-1 self-center"></div>
                    <button type="button" onclick="execCmd('justifyLeft')" class="editor-btn" title="Alinhar à esquerda">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <button type="button" onclick="execCmd('justifyCenter')" class="editor-btn" title="Alinhar ao centro">
                        <i class="fas fa-align-center"></i>
                    </button>
                    <button type="button" onclick="execCmd('justifyRight')" class="editor-btn" title="Alinhar à direita">
                        <i class="fas fa-align-right"></i>
                    </button>
                    <div class="w-px h-6 bg-gray-300 mx-1 self-center"></div>
                    <button type="button" onclick="execCmd('insertImage', prompt('Insira o URL da imagem:'))" class="editor-btn" title="Inserir imagem">
                        <i class="fas fa-image"></i>
                    </button>
                </div>
                
                <div id="editor"
                    contenteditable="true"
                    class="w-full border border-purple-200 rounded-b-lg px-4 py-3 text-gray-800 focus:outline-none">
                    {!! isset($artigo) ? $artigo->conteudo : '' !!}
                </div>
                
                <!-- Textarea escondida que vai realmente enviar o conteúdo -->
                <textarea name="conteudo" id="conteudo" class="hidden"></textarea>
            </div>

            <!-- Upload da Imagem -->
            <div class="mb-6">
                <label for="imagem" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-image mr-1 text-purple-500"></i> Imagem de capa
                </label>
                
                @if(isset($artigo) && $artigo->imagem)
                <div class="mb-3">
                    <div class="flex items-center space-x-4">
                        <div class="w-24 h-24 overflow-hidden rounded-md shadow-md">
                            @php
                                $publicPath = public_path('storage/artigos/' . $artigo->imagem);
                                $storagePath = storage_path('app/public/artigos/' . $artigo->imagem);
                                
                                if (file_exists($publicPath) || file_exists($storagePath)) {
                                    $imagePath = asset('storage/artigos/' . $artigo->imagem);
                                } else {
                                    $imagePath = asset('Icones/artigo1.jpg');
                                }
                            @endphp
                            <img src="{{ $imagePath }}" alt="Imagem atual" class="w-full h-full object-cover"
                                 onerror="this.onerror=null; this.src='{{ asset('Icones/post-it.png') }}';">
                        </div>
                        <div>
                            <p class="text-sm text-gray-700">Imagem atual</p>
                            <div class="flex items-center mt-1">
                                <input type="checkbox" id="remove_image" name="remove_image" class="mr-2">
                                <label for="remove_image" class="text-sm text-gray-600">Usar imagem genérica</label>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                
                @endif
                
                <div class="flex items-center mt-1">
                    <label for="imagem" class="bg-purple-700 hover:bg-purple-800 text-white font-medium px-6 py-3 rounded-lg text-sm cursor-pointer transition flex items-center shadow-md">
                        <i class="fas fa-upload mr-2"></i> Escolher imagem
                    </label>
                    <span id="file-chosen" class="ml-3 text-sm text-gray-600">Nenhum ficheiro selecionado</span>
                    <input type="file" id="imagem" name="imagem" accept="image/*" class="hidden">
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-end mt-8 space-x-3">
                <a href="{{ url()->previous() }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition shadow flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-purple-900 px-6 py-3 rounded-lg font-medium transition shadow-md flex items-center">
                    <i class="fas fa-{{ isset($artigo) ? 'save' : 'paper-plane' }} mr-2"></i> 
                    {{ isset($artigo) ? 'Guardar alterações' : 'Publicar artigo' }}
                </button>
            </div>
        </form>
    </div>
</section>

<script>
    // Funções do editor
    function execCmd(command, value = null) {
        document.execCommand(command, false, value);
        
        // Destaca botões ativos
        if (['bold', 'italic', 'underline'].includes(command)) {
            const button = document.querySelector(`[onclick="execCmd('${command}')"]`);
            if (document.queryCommandState(command)) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        }
    }

    // Monitor do estado do editor para ativar/desativar botões
    document.getElementById('editor').addEventListener('keyup', function() {
        ['bold', 'italic', 'underline'].forEach(cmd => {
            const button = document.querySelector(`[onclick="execCmd('${cmd}')"]`);
            if (document.queryCommandState(cmd)) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        });
    });

    // Mostra o nome do ficheiro selecionado e gerencia a opção "remover imagem"
    document.getElementById('imagem').addEventListener('change', function() {
        const fileChosen = document.getElementById('file-chosen');
        const removeImageCheckbox = document.getElementById('remove_image');
        
        if (this.files.length > 0) {
            fileChosen.textContent = this.files[0].name;
            // Se o utilizador selecionar uma nova imagem, desmarque a opção de remover
            if (removeImageCheckbox) {
                removeImageCheckbox.checked = false;
            }
        } else {
            fileChosen.textContent = 'Nenhum ficheiro selecionado';
        }
    });
    
    // Se existe o checkbox de remover imagem, adicione o listener para ele
    const removeImageCheckbox = document.getElementById('remove_image');
    if (removeImageCheckbox) {
        removeImageCheckbox.addEventListener('change', function() {
            const fileInput = document.getElementById('imagem');
            const fileChosen = document.getElementById('file-chosen');
            
            // Se o utilizador marcar para usar imagem genérica, limpe a seleção de ficheiro
            if (this.checked) {
                fileInput.value = '';
                fileChosen.textContent = 'Nenhum ficheiro selecionado';
            }
        });
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
