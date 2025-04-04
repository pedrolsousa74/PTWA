<header class="bg-gray-900 text-white py-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center px-6">
        <!-- Logo -->
        <a href="#" class="text-3xl font-bold tracking-wide">POST-IT</a>

        <!-- Navegação -->
        <nav class="hidden md:flex space-x-6">
            <a href="#" class="hover:text-purple-400 transition">Início</a>
            <a href="#" class="hover:text-purple-400 transition">Tendências</a>
            <a href="#" class="hover:text-purple-400 transition">Escrever</a>
            <a href="#" class="hover:text-purple-400 transition">Sobre</a>
        </nav>

        <!-- Botão de Login/Perfil -->
        <div class="flex items-center space-x-4">
            <a href="#" class="hidden md:block bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">Entrar</a>

            <!-- Ícone de perfil -->
            <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center cursor-pointer">
                <span class="text-sm font-semibold">👤</span> 
            </div>
        </div>
        
        <!-- Menu Mobile -->
        <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </button>
    </div>

    <!-- Menu Mobile (oculto por padrão) -->
    <div id="mobile-menu" class="hidden md:hidden bg-gray-800 text-white py-4">
        <nav class="flex flex-col items-center space-y-4">
            <a href="#" class="hover:text-purple-400 transition">Início</a>
            <a href="#" class="hover:text-purple-400 transition">Tendências</a>
            <a href="#" class="hover:text-purple-400 transition">Escrever</a>
            <a href="#" class="hover:text-purple-400 transition">Sobre</a>
        </nav>
    </div>

    <script>
        document.getElementById("menu-toggle").addEventListener("click", function() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });
    </script>
</header>
