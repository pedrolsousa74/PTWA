<!DOCTYPE html>
<html>
<head>
    <title>Recuperação de Senha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #7e57c2;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            background-color: #7e57c2;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="logo">POST-IT</div>
    
    <div class="content">
        <h2>Recuperação de Senha</h2>
        <p>Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.</p>
        
        <p>Clique no botão abaixo para redefinir sua senha:</p>
        
        <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="button">Redefinir Senha</a>
        
        <p>Este link de redefinição de senha expirará em 60 minutos.</p>
        
        <p>Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} Post-it. Todos os direitos reservados.</p>
    </div>
</body>
</html>
