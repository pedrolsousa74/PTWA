<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$artigos = App\Models\Artigo::whereNotNull('imagem')->get(['id', 'titulo', 'imagem']);

echo "Articles with images:\n";
foreach ($artigos as $artigo) {
    $filename = $artigo->imagem;
    $storagePath = storage_path('app/public/artigos/' . $filename);
    $publicPath = public_path('storage/artigos/' . $filename);
    
    $storageExists = file_exists($storagePath);
    $publicExists = file_exists($publicPath);
    
    echo "ID: {$artigo->id}, Title: {$artigo->titulo}\n";
    echo "  Image filename: {$filename}\n";
    echo "  Storage path exists: " . ($storageExists ? "YES" : "NO") . "\n";
    echo "  Public path exists: " . ($publicExists ? "YES" : "NO") . "\n";
    echo "  Storage path: {$storagePath}\n";
    echo "  Public path: {$publicPath}\n";
    echo "-------------------------------\n";
}

echo "\nTotal articles with images: " . $artigos->count() . "\n";
