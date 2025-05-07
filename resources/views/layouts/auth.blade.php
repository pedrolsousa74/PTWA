<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Post.it - Ideias que Inspiram')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-purple-700">
    @yield('content')

    @if ($errors->any())
        <div class="max-w-md mx-auto mt-6 bg-red-100 text-red-700 p-4 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</body>
</html>