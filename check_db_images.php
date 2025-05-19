<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$artigos = App\Models\Artigo::whereNotNull('imagem')->get(['id', 'titulo', 'imagem']);

echo "Articles with images:\n";
foreach ($artigos as $artigo) {
    echo "ID: {$artigo->id}, Title: {$artigo->titulo}, Image filename: {$artigo->imagem}\n";
}

echo "\nTotal articles with images: " . $artigos->count() . "\n";

