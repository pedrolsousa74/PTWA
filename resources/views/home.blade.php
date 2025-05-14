@extends('layouts.app')

@section('title', 'Post-it - Ideias que Inspiram')
@vite('resources/css/app.css')

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .bg-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
</style>

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-purple-700 to-purple-900 text-white py-20 shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="container mx-auto flex flex-col lg:flex-row items-center px-6 relative z-10">
            <div class="lg:w-1/2 text-left mb-10 lg:mb-0 animate-fadeIn">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                    Descobre as ideias que estão a 
                    <span class="text-yellow-400">inspirar</span> o mundo.
                </h2>
                <p class="text-xl mb-8 text-gray-200 max-w-lg">Os melhores artigos do momento, selecionados para expandir os seus horizontes.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <button onclick="window.location.href='{{ route('artigos') }}'" class="bg-yellow-500 text-black px-8 py-4 rounded-lg text-lg font-semibold hover:bg-yellow-400 transition transform hover:-translate-y-1 shadow-lg flex items-center justify-center">
                        <i class="fas fa-book-open mr-2"></i> VER ARTIGOS
                    </button>
                    <button onclick="window.location.href='{{ route('escrever') }}'" class="border-2 border-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-purple-700 transition transform hover:-translate-y-1 shadow-lg flex items-center justify-center">
                        <i class="fas fa-pen-fancy mr-2"></i> ESCREVER
                    </button>
                </div>
            </div>
            <div class="lg:w-1/2 flex justify-center lg:justify-end relative">
                <div class="absolute w-72 h-72 bg-purple-500 rounded-full filter blur-3xl opacity-30 -top-10 -right-10"></div>
                <img src="{{ asset('icones/Lampada.webp') }}" alt="Ideias" class="w-48 lg:w-80 relative z-10 animate-float">
            </div>
        </div>
    </section>

    <!-- Tendências -->
    <section class="tendencias py-20 px-6 bg-white text-gray-800">
        <div class="container mx-auto text-center">
            <div class="mb-12 animate-on-scroll">
                <h2 class="text-4xl md:text-5xl font-bold mt-2 mb-4">
                    Tendências
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-6">Descubra os artigos que estão a captar a atenção dos nossos leitores.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @forelse ($tendencias as $index => $artigo)
                    <div class="bg-white text-gray-900 rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 overflow-hidden border border-gray-100 animate-on-scroll" style="animation-delay: {{ $index * 100 }}ms">
                        <div class="relative">
                            <img src="{{ asset('icones/artigo' . ($index % 4 + 1) . '.jpeg') }}" alt="Imagem do Artigo" class="w-full h-52 object-cover">
                            <div class="absolute top-0 right-0 bg-yellow-400 text-xs font-bold uppercase py-1 px-3 rounded-bl-lg">
                                <i class="fas fa-fire mr-1"></i> Popular
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">{{ ucfirst($artigo->categoria ?? 'Geral') }}</span>
                                <span class="ml-2 text-xs text-gray-500">{{ $artigo->created_at->format('d/m/Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3 line-clamp-2">{{ $artigo->titulo }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit(strip_tags($artigo->conteudo), 120) }}</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-purple-200 flex items-center justify-center mr-2">
                                        <span class="font-medium text-purple-800">{{ substr($artigo->user->name ?? 'A', 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm text-gray-700">{{ $artigo->user->name ?? 'Anónimo' }}</span>
                                </div>
                                <a href="{{ route('artigos.show', $artigo->id) }}" class="flex items-center text-purple-700 hover:text-purple-900 font-medium">
                                    Ler <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 py-20 animate-on-scroll">
                        <div class="text-center">
                            <i class="fas fa-newspaper text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500 text-xl">Ainda não há artigos em tendência.</p>
                            <a href="{{ route('escrever') }}" class="mt-4 inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                                <i class="fas fa-pen-fancy mr-2"></i> Seja o primeiro a escrever
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
            
            @if(count($tendencias) > 0)
                <div class="mt-12 animate-on-scroll">
                    <a href="{{ route('artigos') }}" class="inline-block border-2 border-purple-600 text-purple-600 hover:bg-purple-600 hover:text-white px-8 py-3 rounded-lg transition duration-300 font-medium">
                        Ver Todos os Artigos
                    </a>
                </div>
            @endif
        </div>
    </section>



    <!-- Escrever Artigo -->
    <section class="escrever bg-gradient-to-r from-purple-800 to-purple-900 text-white py-24 px-6 relative overflow-hidden">
        <!-- Elementos decorativos -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute w-96 h-96 bg-purple-600 rounded-full opacity-20 -top-20 -left-20"></div>
            <div class="absolute w-80 h-80 bg-yellow-400 rounded-full opacity-10 bottom-10 right-10"></div>
        </div>
        
        <div class="container mx-auto flex flex-col-reverse lg:flex-row items-center relative z-10">
            <div class="lg:w-1/2 flex justify-center lg:justify-start mb-8 lg:mb-0 animate-on-scroll">
                <div class="relative">
                    <div class="absolute inset-0 bg-yellow-400 rounded-full blur-lg opacity-30 transform scale-110"></div>
                    <img src="{{ asset('icones/escrever.webp') }}" alt="Escrever artigo" class="w-48 lg:w-72 relative z-10 animate-float">
                </div>
            </div>
            <div class="lg:w-1/2 text-center lg:text-left animate-on-scroll">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6 leading-tight">Tens algo a <span class="text-yellow-400">dizer</span>? <br class="hidden md:block"> Começa a escrever!</h2>
                <p class="text-lg md:text-xl mb-8 text-gray-200 max-w-lg mx-auto lg:mx-0">Transforma os teus pensamentos em palavras. Partilha conhecimento, inspira outros e faça parte da nossa comunidade.</p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                    <button onclick="window.location.href='{{ route('escrever') }}'" class="bg-yellow-500 text-black px-8 py-4 rounded-lg text-lg font-semibold hover:bg-yellow-400 transition transform hover:-translate-y-1 shadow-lg flex items-center justify-center">
                        <i class="fas fa-pen-fancy mr-2"></i> PUBLICAR ARTIGO
                    </button>
                    <button onclick="window.location.href='{{ route('sobre') }}'" class="border-2 border-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-purple-700 transition transform hover:-translate-y-1 flex items-center justify-center">
                        <i class="fas fa-info-circle mr-2"></i> SABER MAIS
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-6 bg-gray-50">
        <div class="container mx-auto">
            <div class="text-center mb-16 animate-on-scroll">
                <span class="text-sm font-bold text-purple-600 uppercase tracking-wider">Por que escolher o Post-it</span>
                <h2 class="text-4xl font-bold mt-2 mb-4">Uma plataforma feita para ideias</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Descubra as vantagens de fazer parte da nossa comunidade de criadores de conteúdo.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 animate-on-scroll">
                    <div class="bg-purple-100 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-pen-to-square text-2xl text-purple-700"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Publicação Simples</h3>
                    <p class="text-gray-600">Interface intuitiva para publicar suas ideias sem complicações, com ferramentas de formatação e edição fáceis de usar.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 animate-on-scroll" style="animation-delay: 100ms">
                    <div class="bg-blue-100 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-users text-2xl text-blue-700"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Comunidade Engajada</h3>
                    <p class="text-gray-600">Conecte-se com leitores e outros autores que compartilham dos mesmos interesses e paixões.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 animate-on-scroll" style="animation-delay: 200ms">
                    <div class="bg-amber-100 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-2xl text-amber-700"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Visibilidade</h3>
                    <p class="text-gray-600">Seus artigos serão exibidos para um público interessado, com ferramentas para aumentar seu alcance.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Criar Conta -->
    <section class="criar-conta text-center py-20 bg-white relative overflow-hidden animate-on-scroll">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-800 to-purple-900 opacity-90"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 w-full max-w-5xl mx-auto rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">
                <div class="md:w-1/2 p-12 flex flex-col justify-center items-start text-left">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6 leading-tight text-white">
                        Cria conta e começa a publicar <span class="text-purple-900">hoje mesmo</span>
                    </h2>
                    <p class="text-white mb-8 opacity-90">Junte-se à nossa comunidade de autores e partilhe as suas ideias com o mundo. É rápido e gratuito!</p>
                    <button onclick="window.location.href='{{ route('register') }}'" class="bg-purple-800 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-purple-900 transition transform hover:-translate-y-1 shadow-lg flex items-center">
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

    <!-- Testimonials/Stats Section -->
    <section class="py-20 px-6 bg-white">
        <div class="container mx-auto text-center animate-on-scroll">
            <span class="text-sm font-bold text-purple-600 uppercase tracking-wider">POST-IT EM NÚMEROS</span>
            <h2 class="text-4xl font-bold mt-2 mb-12">Junte-se à comunidade</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-10">
                <div class="p-6 rounded-lg">
                    <div class="text-5xl font-bold text-purple-700 mb-2">{{ App\Models\Artigo::count() ?? '120' }}+</div>
                    <p class="text-gray-600">Artigos Publicados</p>
                </div>
                
                <div class="p-6 rounded-lg">
                    <div class="text-5xl font-bold text-purple-700 mb-2">{{ App\Models\User::count() ?? '50' }}+</div>
                    <p class="text-gray-600">Utilizadores Registados</p>
                </div>
                
                <div class="p-6 rounded-lg">
                    <div class="text-5xl font-bold text-purple-700 mb-2">{{ App\Models\Comentario::count() ?? '300' }}+</div>
                    <p class="text-gray-600">Comentários</p>
                </div>
                
                <div class="p-6 rounded-lg">
                    <div class="text-5xl font-bold text-purple-700 mb-2">{{ App\Models\Artigo::distinct('categoria')->count() ?? '10' }}+</div>
                    <p class="text-gray-600">Categorias</p>
                </div>
            </div>
        </div>
    </section>

    
@endsection
