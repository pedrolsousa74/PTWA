<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Painel de Administração</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }
        main {
            flex: 1;
            display: flex;
        }
        .admin-sidebar {
            width: 280px;
            background-color: #4b2d83;
            color: white;
            padding: 1.5rem 1rem;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .admin-content {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            background-color: #f7f9fc;
        }
        .menu-item {
            margin-bottom: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .active-menu-item {
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-800 to-purple-900 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold tracking-wide">
                    <i class="fas fa-feather-alt mr-2"></i>POST.IT - Painel de Administração
                </h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="flex items-center bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-external-link-alt mr-2"></i> Ver Site
                </a>
                <div class="flex items-center bg-purple-700 rounded-full px-4 py-2">
                    <i class="fas fa-user-circle mr-2 text-xl"></i>
                    <span>Olá, {{ Auth::user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                        <i class="fas fa-sign-out-alt mr-1"></i> Sair
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="mb-8 text-center">
                <div class="inline-block p-3 bg-white rounded-full mb-2">
                    <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-10 h-10">
                </div>
                <h2 class="text-xl font-semibold text-white">Post.it Admin</h2>
                <p class="text-sm text-purple-200">Gerir conteúdos e utilizadores</p>
            </div>
            
            <nav>
                <ul class="space-y-1">
                    <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active-menu-item' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-4 text-white hover:text-white">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i> 
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.artigos') ? 'active-menu-item' : '' }}">
                        <a href="{{ route('admin.artigos') }}" class="flex items-center py-3 px-4 text-white hover:text-white">
                            <i class="fas fa-newspaper mr-3 w-5 text-center"></i> 
                            <span>Artigos</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.utilizadores') ? 'active-menu-item' : '' }}">
                        <a href="{{ route('admin.utilizadores') }}" class="flex items-center py-3 px-4 text-white hover:text-white">
                            <i class="fas fa-users mr-3 w-5 text-center"></i> 
                            <span>Utilizadores</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.comentarios') ? 'active-menu-item' : '' }}">
                        <a href="{{ route('admin.comentarios') }}" class="flex items-center py-3 px-4 text-white hover:text-white">
                            <i class="fas fa-comments mr-3 w-5 text-center"></i> 
                            <span>Comentários</span>
                        </a>
                    </li>
                    <div class="border-t border-purple-700 my-4"></div>
                    <li class="menu-item">
                        <a href="{{ route('home') }}" class="flex items-center py-3 px-4 text-white hover:text-white">
                            <i class="fas fa-home mr-3 w-5 text-center"></i> 
                            <span>Página Inicial</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>        <!-- Content -->
        <div class="admin-content bg-gray-100">
            <div class="max-w-7xl mx-auto px-4">
                <!-- Breadcrumb -->
                <div class="py-4 flex items-center text-sm text-gray-500 mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600 transition-colors">
                        <i class="fas fa-home"></i>
                    </a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-700 font-medium">@yield('title')</span>
                </div>
                
                <!-- Mensagens de sucesso/erro -->
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 p-4 mb-6 rounded-md shadow-sm flex items-start" role="alert">
                        <div class="mr-3 text-green-500"><i class="fas fa-check-circle text-xl"></i></div>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 p-4 mb-6 rounded-md shadow-sm flex items-start" role="alert">
                        <div class="mr-3 text-red-500"><i class="fas fa-exclamation-circle text-xl"></i></div>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Page title -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('page-title')</h2>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-1"></i> {{ date('d/m/Y') }}
                    </div>
                </div>

                <!-- Card container -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <!-- Main content -->
                    @yield('content')                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-4">
        <div class="container mx-auto text-center">
            <div class="flex justify-center items-center space-x-4 mb-2">
                <a href="#" class="text-gray-300 hover:text-white transition-colors"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-gray-300 hover:text-white transition-colors"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-gray-300 hover:text-white transition-colors"><i class="fab fa-instagram"></i></a>
            </div>
            <p>&copy; {{ date('Y') }} POST.IT - Todos os direitos reservados</p>
            <p class="text-xs mt-1">Versão 1.0.0</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Adicionar animação suave ao carregamento da página
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('fade-in');
        });
    </script>
    @yield('scripts')
</body>
</html>
