@extends('layouts.app')

@section('title', 'Post-it - Ideias que Inspiram')
@vite('resources/css/app.css')

<!-- Marcar esta página como home-page para o JavaScript saber -->
<div class="home-page" style="display: none;"></div>



<script>
    // Mostrar painel de debug apenas se ?debug=true estiver presente na URL
    if (window.location.search.includes('debug=true')) {
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('debug-panel').style.display = 'block';
            
            document.getElementById('debug-dropdown').addEventListener('click', function() {
                const dropdown = document.getElementById('profile-dropdown');
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                    console.log('Debug: Dropdown toggled via debug panel');
                }
            });
        });
    }
</script>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Apenas inicializa as animações, sem interferir no dropdown
        
        // Add a small delay before activating animations
        setTimeout(function() {
            // Adiciona animação de fade-in aos elementos da página
            const animatedElements = document.querySelectorAll('.animate-on-scroll');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fadeIn');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            animatedElements.forEach(el => {
                observer.observe(el);
            });
        }, 100);
    });
</script>
<style>
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 1s ease-in-out forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .bg-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .section-elevated {
        margin-top: -2rem;
        margin-bottom: 0;
        position: relative;
        z-index: 5; /* Reduzido para garantir que não interfira com o dropdown */
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2),
                    0 10px 10px -5px rgba(0, 0, 0, 0.1),
                    0 -20px 25px -5px rgba(0, 0, 0, 0.2),
                    0 -10px 10px -5px rgba(0, 0, 0, 0.1);
    }
    
    .section-raised {
        position: relative;
        z-index: 1; /* Reduzido para garantir que não interfira com o dropdown */
        overflow-x: hidden;
    }
    
    .container {
        overflow-x: hidden;
    }
</style>

@section('content')
    <!-- Hero Section -->
    <section class="bg-purple-700 text-white py-20 shadow-lg relative overflow-hidden section-elevated">
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="container mx-auto flex flex-col lg:flex-row items-center px-6 relative z-10">
            <div class="lg:w-1/2 text-left mb-10 lg:mb-0 animate-fadeIn">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                    Descobre as ideias que estão a 
                    <span class="text-yellow-400">inspirar</span> o mundo.
                </h2>
                <p class="text-xl mb-8 text-gray-200 max-w-lg">Os melhores artigos do momento, selecionados para expandir os seus horizontes.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <button onclick="window.location.href='{{ route('artigos') }}'" class="bg-yellow-500 text-black px-8 py-4 rounded-lg text-lg font-semibold hover:bg-yellow-400 transition shadow-lg flex items-center justify-center">
                        <i class="fas fa-book-open mr-2"></i> VER ARTIGOS
                    </button>
                    <button onclick="window.location.href='{{ route('escrever') }}'" class="border-2 border-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-purple-50 hover:text-purple-700 transition shadow-lg flex items-center justify-center">
                        <i class="fas fa-pen-fancy mr-2"></i> ESCREVER
                    </button>
                </div>
            </div>
            <div class="lg:w-1/2 flex justify-center lg:justify-end relative overflow-hidden">
                <div class="absolute w-72 h-72 bg-purple-500 rounded-full filter blur-3xl opacity-30 top-0 right-0"></div>
                <img src="{{ asset('icones/Lampada.webp') }}" alt="Ideias" class="w-48 lg:w-80 relative z-10 animate-float">
            </div>
        </div>
    </section>

    <!-- Tendências -->
    <section class="tendencias py-20 px-6 bg-purple-700 text-white relative overflow-hidden shadow-lg section-raised">
        <!-- Elementos decorativos -->
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute w-80 h-80 bg-purple-600 rounded-full opacity-20 top-0 right-20"></div>
            <div class="absolute w-72 h-72 bg-yellow-400 rounded-full opacity-10 top-10 left-0"></div>
            <div class="absolute w-64 h-64 bg-purple-500 rounded-full filter blur-3xl opacity-20 bottom-0 right-10"></div>
        </div>
        <div class="container mx-auto text-center relative z-10">
            <div class="mb-12 animate-fadeIn">
                <h2 class="text-4xl md:text-5xl font-bold mt-2 mb-4">
                    Tendências
                </h2>
                <p class="text-gray-300 max-w-2xl mx-auto mt-6">Descubra os artigos que estão a captar a atenção dos nossos leitores.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 w-full overflow-hidden">
                @forelse ($tendencias as $index => $artigo)
                    <div class="bg-white text-purple-900 rounded-xl shadow-md hover:shadow-xl transition hover:bg-gray-50 overflow-hidden border border-purple-300 animate-on-scroll w-full" style="animation-delay: {{ $index * 100 }}ms">
                        <div class="relative">
                            <img src="{{ asset('icones/artigo' . ($index % 4 + 1) . '.jpeg') }}" alt="Imagem do Artigo" class="w-full h-52 object-cover">
                            <div class="absolute top-0 right-0 bg-white text-purple-900 text-xs font-bold uppercase py-1 px-3 rounded-bl-lg border border-purple-200">
                                <i class="fas fa-fire mr-1"></i> Popular
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <span class="bg-purple-100 text-purple-900 text-xs px-2 py-1 rounded-full">{{ ucfirst($artigo->categoria ?? 'Geral') }}</span>
                                <span class="ml-2 text-xs text-purple-500">{{ $artigo->created_at->format('d/m/Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3 line-clamp-2 text-purple-900">{{ $artigo->titulo }}</h3>
                            <p class="text-purple-700 mb-4 line-clamp-3">{{ Str::limit(strip_tags($artigo->conteudo), 120) }}</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                                        <span class="font-medium text-purple-900">{{ substr($artigo->user->name ?? 'A', 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm text-purple-700">{{ $artigo->user->name ?? 'Anónimo' }}</span>
                                </div>
                                <a href="{{ route('artigos.show', $artigo->id) }}" class="flex items-center text-purple-600 hover:text-purple-800 font-medium">
                                    Ler <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 py-20 animate-on-scroll">
                        <div class="text-center">
                            <i class="fas fa-newspaper text-yellow-300 text-5xl mb-4"></i>
                            <p class="text-yellow-200 text-xl">Ainda não há artigos em tendência.</p>
                            <a href="{{ route('escrever') }}" class="mt-4 inline-block bg-white text-purple-900 px-6 py-3 rounded-lg hover:bg-gray-100 transition">
                                <i class="fas fa-pen-fancy mr-2"></i> Seja o primeiro a escrever
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
            
            @if(count($tendencias) > 0)
                <div class="mt-12 animate-on-scroll">
                    <a href="{{ route('artigos') }}" class="inline-block border-2 border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-purple-900 px-8 py-3 rounded-lg transition duration-300 font-medium">
                        Ver Todos os Artigos
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Escrever Artigo -->
    <section class="escrever bg-purple-700 text-white py-24 px-6 relative overflow-hidden shadow-lg section-elevated">
        <!-- Elementos decorativos -->
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute w-96 h-96 bg-purple-600 rounded-full opacity-20 top-0 left-0"></div>
            <div class="absolute w-80 h-80 bg-yellow-400 rounded-full opacity-10 bottom-10 right-10"></div>
            <div class="absolute w-72 h-72 bg-purple-500 rounded-full filter blur-3xl opacity-30 top-10 right-0"></div>
        </div>
        
        <div class="container mx-auto flex flex-col-reverse lg:flex-row items-center relative z-10">
            <div class="lg:w-1/2 flex justify-center lg:justify-start mb-8 lg:mb-0 animate-on-scroll">
                <div class="relative">
                    <div class="absolute inset-0 bg-yellow-400 rounded-full blur-2xl opacity-30 transform scale-125"></div>
                    <img src="{{ asset('icones/escrever.webp') }}" alt="Escrever artigo" class="w-48 lg:w-72 relative z-10 animate-float">
                </div>
            </div>
            <div class="lg:w-1/2 text-center lg:text-left animate-fadeIn">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6 leading-tight">Tens algo a <span class="text-yellow-400">dizer</span>? <br class="hidden md:block"> Começa a escrever!</h2>
                <p class="text-xl mb-8 text-gray-200 max-w-lg mx-auto lg:mx-0">Transforma os teus pensamentos em palavras. Partilha conhecimento, inspira outros e faça parte da nossa comunidade.</p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                    <button onclick="window.location.href='{{ route('escrever') }}'" class="bg-yellow-500 text-black px-8 py-4 rounded-lg text-lg font-semibold hover:bg-yellow-400 transition shadow-lg flex items-center justify-center">
                        <i class="fas fa-pen-fancy mr-2"></i> PUBLICAR ARTIGO
                    </button>
                    <button onclick="window.location.href='{{ route('sobre') }}'" class="border-2 border-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-purple-50 hover:text-purple-700 transition flex items-center justify-center">
                        <i class="fas fa-info-circle mr-2"></i> SABER MAIS
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-6 bg-purple-700 text-white relative overflow-hidden shadow-lg">
        <!-- Elementos decorativos -->
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute w-80 h-80 bg-purple-600 rounded-full opacity-20 top-0 right-20"></div>
            <div class="absolute w-72 h-72 bg-yellow-400 rounded-full opacity-10 top-10 left-0"></div>
            <div class="absolute w-64 h-64 bg-purple-500 rounded-full filter blur-3xl opacity-20 bottom-0 right-10"></div>
        </div>
        <div class="container mx-auto relative z-10">
            <div class="text-center mb-16 animate-fadeIn">
                <span class="text-sm font-bold text-purple-200 uppercase tracking-wider">Por que escolher o Post-it</span>
                <h2 class="text-4xl font-bold mt-2 mb-4">Uma plataforma feita para ideias</h2>
                <p class="text-gray-300 max-w-2xl mx-auto">Descubra as vantagens de fazer parte da nossa comunidade de criadores de conteúdo.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full overflow-hidden">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-purple-300 hover:shadow-lg transition-all duration-300 animate-on-scroll w-full">
                    <div class="bg-purple-100 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-pen-to-square text-2xl text-purple-900"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-purple-900">Publicação Simples</h3>
                    <p class="text-purple-700">Interface intuitiva para publicar suas ideias sem complicações, com ferramentas de formatação e edição fáceis de usar.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-sm border border-purple-300 hover:shadow-lg transition-all duration-300 animate-on-scroll" style="animation-delay: 100ms">
                    <div class="bg-purple-100 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-users text-2xl text-purple-900"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-purple-900">Comunidade Engajada</h3>
                    <p class="text-purple-700">Conecte-se com leitores e outros autores que compartilham dos mesmos interesses e paixões.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-sm border border-purple-300 hover:shadow-lg transition-all duration-300 animate-on-scroll" style="animation-delay: 200ms">
                    <div class="bg-purple-100 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-2xl text-purple-900"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-purple-900">Visibilidade</h3>
                    <p class="text-purple-700">Seus artigos serão exibidos para um público interessado, com ferramentas para aumentar seu alcance.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Criar Conta -->
    <section class="criar-conta text-center py-20 bg-purple-700 relative overflow-hidden shadow-lg animate-on-scroll section-elevated">
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute w-96 h-96 bg-purple-600 rounded-full opacity-20 top-0 right-0"></div>
            <div class="absolute w-80 h-80 bg-yellow-400 rounded-full opacity-10 bottom-10 left-10"></div>
            <div class="absolute w-72 h-72 bg-purple-500 rounded-full filter blur-3xl opacity-30 top-10 right-10"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 w-full max-w-5xl mx-auto rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">
                <div class="md:w-1/2 p-12 flex flex-col justify-center items-start text-left">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6 leading-tight text-white">
                        Cria conta e começa a publicar <span class="text-purple-900">hoje mesmo</span>
                    </h2>
                    <p class="text-white mb-8 opacity-90">Junte-se à nossa comunidade de autores e partilhe as suas ideias com o mundo. É rápido e gratuito!</p>
                    <button onclick="window.location.href='{{ route('register') }}'" class="bg-purple-800 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-purple-900 transition shadow-lg flex items-center">
                        <i class="fas fa-user-plus mr-2"></i> CRIAR CONTA
                    </button>
                </div>
                <div class="md:w-1/2 relative">
                    <div class="absolute inset-0 bg-pattern opacity-10"></div>
                    <div class="h-full flex items-center justify-center p-8">
                        <div class="relative">
                            <div class="absolute inset-0 bg-purple-600 rounded-full blur-2xl opacity-30 transform scale-125"></div>
                            <img src="{{ asset('icones/Imagem mão.png') }}" alt="Criação de conteúdo" class="max-h-60 relative z-10">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
