<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/post.it.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        html {
            box-sizing: border-box;
            height: 100%;
        }
        
        *, *:before, *:after {
            box-sizing: inherit;
        }
        
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        
        header {
            flex-shrink: 0;
            isolation: isolate; /* Cria um novo contexto de empilhamento */
        }
        
        main {
            flex: 1 0 auto;
            overflow-x: hidden;
        }
        
        footer {
            flex-shrink: 0;
        }
        
        /* Estilos base para o dropdown do perfil */
        #profile-dropdown {
            position: fixed !important; /* Usamos fixed para controle total pelo JavaScript */
            width: 12rem !important;
            z-index: 99999 !important; /* valor muito alto para garantir que fique acima de tudo */
            background-color: white !important;
            border-radius: 0.375rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            max-height: calc(100vh - 5rem) !important; /* altura máxima relativa à altura da janela */
            overflow-y: auto !important; /* habilita scroll apenas dentro do dropdown */
            overflow-x: hidden !important; /* previne scroll horizontal */
            /* removidos right e top porque são controlados pelo JavaScript */
        }
        
        #profile-dropdown.hidden {
            display: none !important;
        }
        
        /* Estilo adicional quando dropdown estiver visível */
        #profile-dropdown:not(.hidden) {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Estilo específico para página inicial */
        .home-page-dropdown {
            /* Estilos são aplicados dinamicamente pelo JavaScript */
        }
        
        /* Prevenir comportamento de scroll não intencional */
        body.dropdown-open {
            overflow: hidden;
        }
        
        /* Classe para debugging - só usar se necessário */
        .debug-dropdown {
            border: 2px dashed red !important;
        }
        
        /* Botão do perfil */
        #profile-toggle {
            cursor: pointer;
        }
    </style>
</head>
<body>
    @include('layouts.header')
    <script>
        // Script global para inicialização da página
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar se estamos na página inicial
            const isHomePage = document.querySelector('.home-page') !== null;
            // Inicializar dropdown do perfil globalmente
            const toggle = document.getElementById('profile-toggle');
            const dropdown = document.getElementById('profile-dropdown');
            
            if (toggle && dropdown) {
                // Garantir propriedades corretas para o dropdown
                dropdown.style.zIndex = "99999";
                
                // Função para posicionar o dropdown corretamente
                function positionDropdown() {
                    const rect = toggle.getBoundingClientRect();
                    dropdown.style.position = "fixed";
                    dropdown.style.top = (rect.bottom + 8) + "px"; // 8px de espaço
                    
                    // Centralizar o dropdown embaixo do botão
                    const dropdownWidth = dropdown.offsetWidth || 192; // 12rem = 192px
                    const buttonCenter = rect.left + (rect.width / 2);
                    const left = Math.round(buttonCenter - (dropdownWidth / 2)); // Arredondar para evitar problemas de pixel
                    
                    // Garantir que não fique fora da tela
                    const rightEdge = left + dropdownWidth;
                    if (rightEdge > window.innerWidth) {
                        dropdown.style.right = "10px";
                        dropdown.style.left = "auto";
                    } else if (left < 10) {
                        dropdown.style.left = "10px";
                        dropdown.style.right = "auto";
                    } else {
                        dropdown.style.left = left + "px";
                        dropdown.style.right = "auto";
                    }
                    
                    dropdown.style.maxHeight = "calc(100vh - " + (rect.bottom + 20) + "px)";
                }
                
                // Posicionar o dropdown inicialmente
                positionDropdown();
                
                // Atualizar posição ao redimensionar a janela ou ao rolar a página
                window.addEventListener('resize', positionDropdown);
                window.addEventListener('scroll', function() {
                    // Só reposicionar se o dropdown estiver visível
                    if (!dropdown.classList.contains('hidden')) {
                        positionDropdown();
                    }
                });
                
                // Adicionar evento de clique ao botão
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                    
                    // Se estiver visível, atualizar posição
                    if (!dropdown.classList.contains('hidden')) {
                        // Pequeno atraso para garantir que tudo esteja renderizado
                        setTimeout(positionDropdown, 0);
                        // Adicionar preventDefault para cliques dentro do dropdown
                        dropdown.addEventListener('wheel', function(event) {
                            const isScrollingDown = event.deltaY > 0;
                            const isAtBottom = dropdown.scrollHeight - dropdown.scrollTop === dropdown.clientHeight;
                            const isAtTop = dropdown.scrollTop === 0;
                            
                            // Só impedir o evento padrão se tentar rolar além dos limites do dropdown
                            if ((isScrollingDown && isAtBottom) || (!isScrollingDown && isAtTop)) {
                                event.preventDefault();
                            }
                            
                            // Sempre parar a propagação para evitar que a página role
                            event.stopPropagation();
                        });
                    }
                });
                
                // Fechar ao clicar em qualquer outro lugar
                document.addEventListener('click', function(e) {
                    if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
                
                // Fechar ao pressionar ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        dropdown.classList.add('hidden');
                    }
                });
            }
            
            // Menu mobile
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
        
        // Prevenir saltos de rolagem ao carregar a página
        window.addEventListener('load', function() {
            window.scrollTo(0, 0);
        });
    </script>
    @yield('scripts')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')
</body>
</html>
