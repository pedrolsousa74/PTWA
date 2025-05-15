@extends('layouts.app')

@section('title', 'Sobre Nós - Post.it')
@vite('resources/css/app.css')

<style>
    .bg-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .animate-fadeIn {
        animation: fadeIn 1s ease-in-out forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@section('content')
<!-- Hero Section -->
<section class="bg-purple-700 text-white py-16 shadow-lg relative overflow-hidden">
    <div class="absolute inset-0 bg-pattern opacity-10"></div>
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute w-96 h-96 bg-purple-600 rounded-full opacity-20 top-0 right-20"></div>
        <div class="absolute w-80 h-80 bg-yellow-400 rounded-full opacity-10 bottom-10 left-10"></div>
        <div class="absolute w-72 h-72 bg-purple-500 rounded-full filter blur-3xl opacity-30 top-10 right-0"></div>
    </div>
    <div class="container mx-auto px-6 relative z-10">
        <h1 class="text-5xl font-bold mb-4 leading-tight">Sobre nós!</h1>
        <p class="text-xl mb-6">Descobre quem somos e a nossa missão de conectar pessoas através de ideias.</p>
    </div>
</section>

<!-- Estatísticas -->
<section class="bg-white py-16 relative overflow-hidden">
    <div class="container mx-auto text-center relative z-10 px-6">
        <div class="inline-block mb-2 bg-purple-100 px-4 py-1 rounded-full">
            <span class="text-sm font-bold text-purple-700 uppercase tracking-wider">POST-IT EM NÚMEROS</span>
        </div>
        <h2 class="text-3xl font-bold mt-2 mb-4 text-purple-900">Nossa comunidade em crescimento</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-10">Confira os números que demonstram o crescimento contínuo da nossa plataforma, graças à participação ativa de utilizadores como tu.</p>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-10 w-full">
            <div class="bg-purple-50 p-6 rounded-lg shadow-lg border border-purple-200 hover:shadow-xl transition-all duration-300">
                <div class="text-purple-400 mb-2"><i class="fas fa-newspaper text-3xl"></i></div>
                <div class="text-5xl font-bold text-purple-900 mb-2">{{ App\Models\Artigo::count() ?? '120' }}+</div>
                <p class="text-purple-700">Artigos Publicados</p>
            </div>
            
            <div class="bg-purple-50 p-6 rounded-lg shadow-lg border border-purple-200 hover:shadow-xl transition-all duration-300">
                <div class="text-purple-400 mb-2"><i class="fas fa-users text-3xl"></i></div>
                <div class="text-5xl font-bold text-purple-900 mb-2">{{ App\Models\User::count() ?? '50' }}+</div>
                <p class="text-purple-700">Utilizadores</p>
            </div>
            
            <div class="bg-purple-50 p-6 rounded-lg shadow-lg border border-purple-200 hover:shadow-xl transition-all duration-300">
                <div class="text-purple-400 mb-2"><i class="fas fa-comments text-3xl"></i></div>
                <div class="text-5xl font-bold text-purple-900 mb-2">{{ App\Models\Comentario::count() ?? '300' }}+</div>
                <p class="text-purple-700">Comentários</p>
            </div>
            
            <div class="bg-purple-50 p-6 rounded-lg shadow-lg border border-purple-200 hover:shadow-xl transition-all duration-300">
                <div class="text-purple-400 mb-2"><i class="fas fa-bookmark text-3xl"></i></div>
                <div class="text-5xl font-bold text-purple-900 mb-2">{{ App\Models\Artigo::distinct('categoria')->count() ?? '10' }}+</div>
                <p class="text-purple-700">Categorias</p>
            </div>
        </div>
    </div>
</section>

<!-- Conteúdo principal -->
<div class="max-w-4xl mx-auto py-16 px-6 bg-white">

    <article class="mb-16">
        <div class="flex flex-col md:flex-row items-center mb-10">
            <div class="md:w-1/3 mb-6 md:mb-0 md:pr-10">
                <div class="bg-purple-100 p-6 rounded-xl text-center relative">
                    <div class="absolute top-0 right-0 -mt-3 -mr-3 bg-purple-600 rounded-full h-8 w-8 flex items-center justify-center text-white">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-bold text-purple-800 mb-2">Nossa Equipe</h3>
                    <div class="text-purple-700">5 estudantes apaixonados</div>
                </div>
            </div>
            <div class="md:w-2/3">
                <h2 class="text-3xl font-bold mb-4 text-purple-900 border-b-2 border-purple-200 pb-2">Quem somos</h2>
                <p class="text-gray-700 mb-4">Somos uma equipa composta por 5 estudantes apaixonados da ESTGA, unidos pelo objetivo de criar uma plataforma inovadora que facilite a partilha de ideias e inspire a troca de conhecimento.</p>
                <p class="text-gray-700">Acreditamos no poder das palavras e na capacidade de conectar pessoas, por isso criamos um espaço digital onde todos podem contribuir, aprender e crescer.</p>
            </div>
        </div>
    </article>
    
    <article class="mb-16">
        <div class="flex flex-col md:flex-row-reverse items-center mb-10">
            <div class="md:w-1/3 mb-6 md:mb-0 md:pl-10">
                <div class="bg-purple-100 p-6 rounded-xl text-center relative">
                    <div class="absolute top-0 right-0 -mt-3 -mr-3 bg-purple-600 rounded-full h-8 w-8 flex items-center justify-center text-white">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="text-xl font-bold text-purple-800 mb-2">Nossa Missão</h3>
                    <div class="text-purple-700">Conectar ideias e pessoas</div>
                </div>
            </div>
            <div class="md:w-2/3">
                <h2 class="text-3xl font-bold mb-4 text-purple-900 border-b-2 border-purple-200 pb-2">O que fazemos</h2>
                <p class="text-gray-700">Nossa missão é proporcionar uma plataforma acessível, onde escritores de todas as áreas podem publicar seus artigos e compartilhar suas ideias com um público curioso e ansioso por novos conhecimentos. De temas tecnológicos a reflexões sobre arte, cultura, ciência e muito mais, buscamos explorar e celebrar a diversidade do pensamento. Estamos comprometidos em fomentar uma comunidade aberta, colaborativa e enriquecedora para todos os envolvidos.</p>
            </div>
        </div>
    </article>

    <article class="mb-16">
        <div class="flex flex-col md:flex-row items-center mb-10">
            <div class="md:w-1/3 mb-6 md:mb-0 md:pr-10">
                <div class="bg-purple-100 p-6 rounded-xl text-center relative">
                    <div class="absolute top-0 right-0 -mt-3 -mr-3 bg-purple-600 rounded-full h-8 w-8 flex items-center justify-center text-white">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="text-xl font-bold text-purple-800 mb-2">Diferenciais</h3>
                    <div class="text-purple-700">Interação única e construtiva</div>
                </div>
            </div>
            <div class="md:w-2/3">
                <h2 class="text-3xl font-bold mb-4 text-purple-900 border-b-2 border-purple-200 pb-2">Nosso diferencial</h2>
                <p class="text-gray-700">Além de proporcionar um espaço para a expressão individual, nossa plataforma oferece uma experiência única de interação entre escritores e leitores. Através de comentários, discussões e feedbacks construtivos, promovemos um ambiente onde todos podem crescer e evoluir. Valorizamos cada voz e estamos sempre em busca de novas ideias que possam agregar e transformar o nosso universo de conhecimento.</p>
            </div>
        </div>
    </article>
    
    <!-- Call to Action -->
    <article class="mb-16 bg-gradient-to-r from-purple-700 to-purple-900 text-white p-8 rounded-xl">
        <h2 class="text-3xl font-bold mb-4 border-b-2 border-purple-500 pb-2 inline-block">Junta-te a nós!</h2>
        <p class="mb-6">Se tens uma ideia inovadora, uma reflexão ou uma experiência que gostaria de compartilhar, a nossa plataforma é o lugar perfeito para ti. Estamos à procura de pessoas criativas, curiosas e dispostas a contribuir para um mundo mais conectado e informado.</p>
        
        <div class="mt-8 flex justify-center">
            <a href="{{ route('register') }}" class="bg-yellow-500 text-black px-8 py-4 rounded-lg text-lg font-semibold hover:bg-yellow-400 transition shadow-lg inline-flex items-center mr-4">
                <i class="fas fa-user-plus mr-2"></i> CRIAR CONTA
            </a>
            <a href="{{ route('escrever') }}" class="border-2 border-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-purple-700 transition shadow-lg inline-flex items-center">
                <i class="fas fa-pen-fancy mr-2"></i> ESCREVER ARTIGO
            </a>
        </div>
    </article>

    <article>
        <h2 class="text-3xl font-bold mb-6 text-purple-900 border-b-2 border-purple-200 pb-2">Porque publicar conosco?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <i class="fas fa-eye text-2xl text-purple-700"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-center text-purple-900">Visibilidade</h3>
                <p class="text-gray-700 text-center">A tua voz será ouvida por uma comunidade ativa e diversificada.</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <i class="fas fa-paint-brush text-2xl text-purple-700"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-center text-purple-900">Liberdade criativa</h3>
                <p class="text-gray-700 text-center">O nosso espaço é livre de barreiras e incentiva a expressão genuína.</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <i class="fas fa-chart-line text-2xl text-purple-700"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-center text-purple-900">Crescimento</h3>
                <p class="text-gray-700 text-center">Tens a oportunidade de aprimorar as tuas ideias com o feedback da nossa comunidade.</p>
            </div>
        </div>

    </article>
</div>




@endsection
