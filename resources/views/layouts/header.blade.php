<header class="bg-gray-900 text-white py-4 shadow-md relative z-50">
    <div class="container mx-auto flex justify-between items-center px-6">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="text-3xl font-bold tracking-wide">POST-IT</a>

        <!-- Navegação Desktop -->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ route('artigos') }}" class="hover:text-purple-400 transition">Artigos</a>
            <a href="{{ route('escrever') }}" class="hover:text-purple-400 transition">Escrever</a>
            <a href="{{ route('sobre') }}" class="hover:text-purple-400 transition">Sobre</a>
        </nav>

        <!-- Área do utilizador -->
        <div class="flex items-center space-x-4">
            @auth
                <!-- Nome do utilizador -->
                <span>Olá, {{ Auth::user()->name }}</span>

                <!-- Container relativo para o ícone e dropdown -->
                <div class="relative">
                    <!-- Ícone de perfil -->
                    <button id="profile-toggle" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center focus:outline-none">
                        <span class="text-sm font-semibold">👤</span>
                    </button>

                    <!-- Popup dropdown -->
                    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 z-50 bg-white text-black rounded-md shadow-lg py-2 w-48 z-50">
                        <a href="{{ route('perfil') }}" class="block px-4 py-2 hover:bg-gray-100">Ver perfil</a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 text-purple-700 font-semibold">
                                <i class="fas fa-user-shield mr-2"></i>Painel Admin
                            </a>
                            <div class="border-t border-gray-200 my-1"></div>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Terminar Sessão</button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="hidden md:block bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
                    Entrar
                </a>
            @endguest
        </div>

        <!-- Menu Mobile -->
        <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </button>
    </div>

    <!-- Menu Mobile -->
    <div id="mobile-menu" class="hidden md:hidden bg-gray-800 text-white py-4">
        <nav class="flex flex-col items-center space-y-4">
            <a href="{{ route('home') }}" class="hover:text-purple-400 transition">Início</a>
            <a href="{{ route('artigos') }}" class="hover:text-purple-400 transition">Artigos</a>
            <a href="{{ route('escrever') }}" class="hover:text-purple-400 transition">Escrever</a>
            <a href="{{ route('sobre') }}" class="hover:text-purple-400 transition">Sobre</a>
        </nav>
    </div>
</header>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("profile-toggle");
        const dropdown = document.getElementById("profile-dropdown");

        toggle.addEventListener("click", function () {
            dropdown.classList.toggle("hidden");
        });

        // Fecha o dropdown ao clicar fora
        document.addEventListener("click", function (e) {
            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add("hidden");
            }
        });
    });
</script>
