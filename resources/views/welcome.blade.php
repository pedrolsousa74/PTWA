<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Post-it</title>
</head>
<body>
    <h1>Bem-vindo ao Post-it</h1>
    <p>Clica no botao para veres os arigos.</p>

    <a href="" class="btn">
        <button>Ver artigos</button>
    </a>

    <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
</body>
</html>