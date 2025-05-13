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
        }
        main {
            flex: 1;
            display: flex;
        }
        .admin-sidebar {
            width: 250px;
            background-color: #4b2d83;
            color: white;
            padding: 1rem;
        }
        .admin-content {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-purple-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold">POST.IT - Painel de Administração</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg">
                    Ver Site
                </a>
                <span>Olá, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 rounded hover:bg-purple-700 {{ request()->routeIs('admin.dashboard') ? 'bg-purple-700' : '' }}">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.artigos') }}" class="block py-2 px-4 rounded hover:bg-purple-700 {{ request()->routeIs('admin.artigos') ? 'bg-purple-700' : '' }}">
                            <i class="fas fa-newspaper mr-2"></i> Artigos
                        </a>
                    </li>                    <li>                        <a href="{{ route('admin.utilizadores') }}" class="block py-2 px-4 rounded hover:bg-purple-700 {{ request()->routeIs('admin.utilizadores') ? 'bg-purple-700' : '' }}">
                            <i class="fas fa-users mr-2"></i> Utilizadores
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.comentarios') }}" class="block py-2 px-4 rounded hover:bg-purple-700 {{ request()->routeIs('admin.comentarios') ? 'bg-purple-700' : '' }}">
                            <i class="fas fa-comments mr-2"></i> Comentários
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Content -->
        <div class="admin-content bg-gray-100">
            <div class="container mx-auto">
                <!-- Mensagens de sucesso/erro -->
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Page title -->
                <h2 class="text-2xl font-bold mb-6">@yield('page-title')</h2>

                <!-- Main content -->
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-4">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} POST.IT - Painel de Administração</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
