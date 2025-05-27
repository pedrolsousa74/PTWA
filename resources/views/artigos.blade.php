@extends('layouts.app')

@section('title', 'Post.it - Ideias que Inspiram')
@vite('resources/css/app.css')

<style>
    .bg-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .animate-fadeIn {
        animation: fadeIn 1s ease-in-out forwards;
    }
    
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease-out;
    }
    
    .animate-on-scroll.animated {
        opacity: 1;
        transform: translateY(0);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Estilos do dropdown */
    .filter-container {
        position: relative;
        display: inline-block;
    }
    
    #filter-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 10px;
        transition: all 0.3s ease;
        transform-origin: top left;
        opacity: 1;
        visibility: visible;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        max-height: calc(100vh - 250px);
        overflow-y: auto;
        z-index: 100;
        border-radius: 12px;
        width: 280px;
        border: 1px solid rgba(107, 33, 168, 0.1);
        background: white;
    }
    
    #filter-dropdown.hidden {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px) scale(0.95);
        pointer-events: none;
    }
</style>

@section('content')
<!-- Hero Section -->
<section class="bg-purple-700 text-white py-20 shadow-lg relative overflow-visible">
    <div class="absolute inset-0 bg-pattern opacity-10"></div>
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute w-80 h-80 bg-purple-600 rounded-full opacity-20 top-0 right-20"></div>
        <div class="absolute w-72 h-72 bg-yellow-400 rounded-full opacity-10 top-10 left-0"></div>
        <div class="absolute w-64 h-64 bg-purple-500 rounded-full filter blur-3xl opacity-20 bottom-0 right-10"></div>
    </div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight animate-fadeIn">Explore os <span class="text-yellow-400">melhores</span> artigos!</h1>
            <p class="text-xl mb-8 text-gray-200 max-w-lg">Descobre opiniões, histórias e tendências de diferentes autores da nossa comunidade.</p>

            <!-- Botão Filtrar -->
            <div class="filter-container mt-6">
                <button id="filter-btn" class="bg-yellow-500 text-black px-8 py-4 rounded-lg text-lg font-semibold hover:bg-yellow-400 transition shadow-lg flex items-center">
                    <i class="fas fa-filter mr-2"></i> FILTRAR
                </button>
                <!-- Dropdown de Filtros -->
                <div id="filter-dropdown" class="hidden">
                    <form method="GET" action="{{ route('artigos') }}">
                        <div class="p-5 bg-white rounded-t-xl border-b border-purple-100">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-purple-900 font-bold text-base">Filtrar Artigos</h3>
                                <button type="button" id="close-filter" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-folder mr-1 text-purple-500"></i> Categoria
                                    </label>
                                    <select id="categoria" name="categoria" class="w-full border border-purple-200 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-black">

                                        <option value="">Todas as categorias</option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria }}" {{ request('categoria') == $categoria ? 'selected' : '' }}>{{ ucfirst($categoria) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="usuario" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-user mr-1 text-purple-500"></i> Utilizador
                                    </label>
                                    <input type="text" id="usuario" name="usuario" placeholder="Nome do utilizador" 
                                        class="w-full border border-purple-200 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-black"
                                        value="{{ request('usuario') }}">
                                </div>
                                <div>
                                    <label for="data" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-calendar mr-1 text-purple-500"></i> Data exata
                                    </label>
                                    <input type="date" id="data" name="data" class="w-full border border-purple-200 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-black" value="{{ request('data') }}">

                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-b-xl flex space-x-2">
                            <button type="submit" class="flex-1 bg-purple-700 text-white px-4 py-3 rounded-lg hover:bg-purple-800 transition shadow flex items-center justify-center">
                                <i class="fas fa-search mr-2"></i> Aplicar
                            </button>
                            <a href="{{ route('artigos') }}" class="flex-1 border border-purple-300 text-purple-700 px-4 py-3 rounded-lg hover:bg-purple-50 transition flex items-center justify-center">
                                <i class="fas fa-undo mr-2"></i> Limpar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
        <!-- Indicador de filtros ativos -->
        @if(request('usuario')  request('categoria')  request('data'))
            <div class="bg-purple-50 p-4 rounded-lg mt-6 animate-fadeIn">
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-purple-700 font-medium">Filtros ativos:</span>

                    @if(request('usuario'))
                        <span class="bg-purple-100 text-purple-800 text-sm px-3 py-1 rounded-full flex items-center">
                            <i class="fas fa-user mr-1"></i> Utilizador: {{ request('usuario') }}
                            <a href="{{ route('artigos', array_merge(request()->except('usuario'), ['page' => 1])) }}" class="ml-1 hover:text-purple-900">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif

                    @if(request('categoria'))
                        <span class="bg-purple-100 text-purple-800 text-sm px-3 py-1 rounded-full flex items-center">
                            <i class="fas fa-folder mr-1"></i> Categoria: {{ ucfirst(request('categoria')) }}
                            <a href="{{ route('artigos', array_merge(request()->except('categoria'), ['page' => 1])) }}" class="ml-1 hover:text-purple-900">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif

                    @if(request('data'))
                        <span class="bg-purple-100 text-purple-800 text-sm px-3 py-1 rounded-full flex items-center">
                            <i class="fas fa-calendar mr-1"></i> Data: {{ request('data') }}
                            <a href="{{ route('artigos', array_merge(request()->except('data'), ['page' => 1])) }}" class="ml-1 hover:text-purple-900">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif

                    <a href="{{ route('artigos') }}" class="ml-auto text-purple-700 hover:text-purple-900 text-sm">
                        <i class="fas fa-times-circle mr-1"></i> Limpar todos
                    </a>
                </div>
            </div>
        @endif  
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtn = document.getElementById("filter-btn");
        const filterDropdown = document.getElementById("filter-dropdown");
        const closeFilter = document.getElementById("close-filter");
        const filterContainer = document.querySelector(".filter-container");
        
        // Toggle filter dropdown
        filterBtn.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            filterDropdown.classList.toggle("hidden");
            
            // Garantir que o dropdown esteja visível na viewport
            setTimeout(() => {
                if (!filterDropdown.classList.contains("hidden")) {
                    const rect = filterDropdown.getBoundingClientRect();
                    const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
                    
                    if (rect.bottom > viewportHeight) {
                        // Se o dropdown estiver saindo da tela, ajusta sua posição
                        filterDropdown.style.maxHeight = (viewportHeight - rect.top - 20) + "px";
                    }
                }
            }, 10);
        });
        
        // Fechar dropdown com o botão de fechar
        if (closeFilter) {
            closeFilter.addEventListener("click", function(e) {
                e.preventDefault();
                filterDropdown.classList.add("hidden");
            });
        }
        
        // Fechar dropdown ao clicar fora dele
        document.addEventListener('click', function(e) {
            if (filterDropdown && !filterDropdown.classList.contains("hidden") && 
                !filterDropdown.contains(e.target) && 
                e.target !== filterBtn) {
                filterDropdown.classList.add("hidden");
            }
        });
        
        // Adiciona animação de fade-in aos elementos da página
        setTimeout(function() {
            const animatedElements = document.querySelectorAll('.animate-on-scroll');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        setTimeout(() => {
                            observer.unobserve(entry.target);
                        }, 300);
                    }
                });
            }, { threshold: 0.1 });
            
            animatedElements.forEach(el => {
                observer.observe(el);
            });
        }, 100);
    });
</script>

<!-- Lista de Artigos -->
<section class="bg-white py-16 px-6 relative z-0">
    <div class="absolute inset-0 bg-pattern opacity-5"></div>
    <div class="container mx-auto relative z-10">

        
        <div class="grid gap-8 md:gap-10">
            @forelse ($artigos as $artigo)
            <article class="flex flex-col md:flex-row {{ $loop->iteration % 2 == 0 ? 'md:flex-row-reverse' : '' }} bg-white shadow-lg rounded-xl p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 animate-on-scroll">
                <div class="flex-1 {{ $loop->iteration % 2 == 0 ? 'md:ml-8' : 'md:mr-8' }}">
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="bg-purple-700 text-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                            <i class="far fa-user mr-1"></i> {{ $artigo->user->name ?? 'Anónimo' }}
                        </span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                            <i class="far fa-folder mr-1"></i> {{ ucfirst($artigo->categoria ?? 'Geral') }}
                        </span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                            <i class="far fa-calendar mr-1"></i> {{ $artigo->created_at->format('d/m/Y') }}
                        </span>
                    </div>

                    <h2 class="text-2xl font-bold mb-3 text-purple-900">{{ $artigo->titulo }}</h2>
                    <p class="text-gray-600 mb-6">{{ Str::limit(strip_tags($artigo->conteudo), 150) }}</p>
                    
                    <div class="mt-6 pt-4 border-t border-gray-100 flex items-center space-x-4">
                        <a href="{{ route('artigos.show', $artigo->id) }}" class="bg-purple-700 text-white px-5 py-2 rounded-lg hover:bg-purple-800 transition flex items-center shadow-md">
                            <i class="fas fa-book-open mr-2"></i> Ler Artigo
                        </a>
                        <form action="{{ route('artigos.like', $artigo->id) }}" method="POST" class="flex items-center">
                            @csrf
                            <button type="submit" class="flex items-center justify-center text-red-600 hover:text-red-800 transition">
                                @if ($artigo->usersWhoLiked->contains(auth()->user()))
                                    <i class="fas fa-heart text-xl"></i>
                                @else
                                    <i class="far fa-heart text-xl"></i>
                                @endif
                                <span class="ml-1 font-medium">{{ $artigo->usersWhoLiked->count() }}</span>
                            </button>
                        </form>
                    </div>
                </div>

                @php
                    // Usando post-it.png como imagem padrão para todos os artigos
                    $defaultImage = 'Icones/post-it.png';
                    
                    // Primary path - check both possible paths
                    $imagePath = null;
                    
                    if ($artigo->imagem) {
                        $publicPath = public_path('storage/artigos/' . $artigo->imagem);
                        $storagePath = storage_path('app/public/artigos/' . $artigo->imagem);
                        $directPath = public_path('artigos/' . $artigo->imagem);  // Another possible location
                        
                        if (file_exists($publicPath)) {
                            $imagePath = asset('storage/artigos/' . $artigo->imagem);
                        } elseif (file_exists($storagePath)) {
                            $imagePath = asset('storage/artigos/' . $artigo->imagem);
                        } elseif (file_exists($directPath)) {
                            $imagePath = asset('artigos/' . $artigo->imagem);
                        } else {
                            // Log missing image for debugging
                            // \Log::info('Article image missing: ' . $artigo->imagem);
                            $imagePath = asset($defaultImage);
                        }
                    } else {
                        $imagePath = asset($defaultImage);
                    }
                @endphp

                <div class="{{ $loop->iteration % 2 == 0 ? 'md:mr-4' : 'md:ml-4' }} mb-4 md:mb-0 flex-shrink-0">
                    <img src="{{ $imagePath }}" alt="Imagem do artigo"
                        class="w-full md:w-64 h-48 md:h-48 object-cover rounded-lg shadow-md hover:shadow-lg transition-all duration-300"
                        onerror="this.onerror=null; this.src='{{ asset('Icones/post-it.png') }}';">
                </div>
            </article>
            @empty
            <div class="bg-purple-50 p-8 rounded-xl text-center shadow-inner">
                <div class="text-purple-400 mb-4">
                    <i class="fas fa-newspaper text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-purple-800 mb-2">Nenhum artigo publicado</h3>
                <p class="text-purple-600 mb-4">Seja o primeiro a compartilhar as suas ideias com a comunidade!</p>
                <a href="{{ route('escrever') }}" class="inline-flex items-center bg-purple-700 text-white px-6 py-3 rounded-lg hover:bg-purple-800 transition shadow-md">
                    <i class="fas fa-pen-fancy mr-2"></i> Escrever Artigo
                </a>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
