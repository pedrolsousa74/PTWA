<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$artigos = App\Models\Artigo::whereNotNull('imagem')->get();
$totalFixed = 0;

echo "Checking image references in the database...\n";

foreach ($artigos as $artigo) {
    $storagePath = storage_path('app/public/artigos/' . $artigo->imagem);
    $publicPath = public_path('storage/artigos/' . $artigo->imagem);
    
    if (!file_exists($storagePath) && !file_exists($publicPath)) {
        echo "Article ID: {$artigo->id}, Title: {$artigo->titulo} - Image not found: {$artigo->imagem}\n";
        
        // Reset the image reference if the files don't exist
        $artigo->imagem = null;
        $artigo->save();
        $totalFixed++;
    } else {
        echo "Article ID: {$artigo->id} - Image found: {$artigo->imagem}\n";
    }
}

echo "\nCleaning complete. Fixed {$totalFixed} articles.\n";
