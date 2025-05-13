@php
// Verificar se precisa executar migração
$needsMigration = !Schema::hasTable('users') || !Schema::hasColumn('users', 'is_admin');

// Verificar se existe utilizador admin
$adminExists = false;
if (Schema::hasTable('users') && Schema::hasColumn('users', 'is_admin')) {
    $adminExists = \App\Models\User::where('is_admin', true)->exists();
}
@endphp

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuração de Administrador - Post.it</title>
    <link rel="stylesheet" href="{{ asset('css/post.it.css') }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        h1 {
            color: #6b21a8;
            border-bottom: 2px solid #6b21a8;
            padding-bottom: 10px;
        }
        .step {
            margin-bottom: 20px;
            padding: 15px;
            border-left: 4px solid #6b21a8;
            background-color: #f3f4f6;
        }
        code {
            background-color: #e5e7eb;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
        }
        .terminal {
            background-color: #1e293b;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 6px;
            font-family: monospace;
            overflow-x: auto;
            margin: 15px 0;
        }
        .success {
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin-bottom: 20px;
        }
        .error {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #6b21a8;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #581c87;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Configuração de Administrador - Post.it</h1>
        
        @if($needsMigration)
            <div class="error">
                <h2>Migração Necessária</h2>
                <p>A migração para adicionar o campo <code>is_admin</code> ainda não foi aplicada.</p>
                <div class="terminal">php artisan migrate</div>
                <p>Depois de executar a migração, atualize esta página.</p>
            </div>
        @elseif(!$adminExists)
            <div class="error">
                <h2>Administrador Não Configurado</h2>                <p>Não foi encontrado nenhum utilizador administrador na base de dados.</p>
                <div class="terminal">php artisan admin:create</div>
                <p>Este comando irá criar um utilizador administrador com as seguintes credenciais:</p>
                <ul>
                    <li><strong>Email:</strong> admin@postit.com</li>
                    <li><strong>Senha:</strong> admin123</li>
                </ul>
                <p>Você também pode especificar um email e senha diferentes:</p>
                <div class="terminal">php artisan admin:create seuemail@exemplo.com suasenha</div>
                <p>Depois de criar o administrador, atualize esta página.</p>
            </div>
        @else
            <div class="success">
                <h2>Administrador Configurado</h2>                <p>Um utilizador administrador já existe no sistema.</p>
                <p>Use as credenciais do administrador para aceder ao painel administrativo. Se esqueceu a senha, pode redefini-la usando o comando:</p>
                <div class="terminal">php artisan admin:create admin@postit.com novasenha</div>
            </div>
        @endif

        <div class="step">            <h3>Como aceder ao Painel de Administração</h3>
            <ol>
                <li>Faça login com as credenciais de administrador</li>
                <li>Clique no seu perfil no canto superior direito</li>
                <li>Selecione "Painel Admin" no menu</li>
            </ol>
            <a href="{{ route('login') }}" class="btn">Ir para o Login</a>
        </div>

        <div class="step">
            <h3>Permissões de Administrador</h3>
            <p>Como administrador, você pode:</p>
            <ul>
                <li>Eliminar qualquer artigo publicado no site</li>                <li>Gerir utilizadores e suas permissões</li>
                <li>Promover outros utilizadores a administradores</li>
            </ul>
        </div>
    </div>
</body>
</html>
