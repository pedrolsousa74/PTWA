<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Find an existing article to update
$artigo = App\Models\Artigo::first();

if ($artigo) {
    $artigo->imagem = "test_image.jpg";
    $artigo->save();
    echo "Article ID: {$artigo->id} updated with test_image.jpg\n";
    
    // Now verify image paths
    $storagePath = storage_path('app/public/artigos/' . $artigo->imagem);
    $publicPath = public_path('storage/artigos/' . $artigo->imagem);
    
    echo "Storage path: {$storagePath}\n";
    echo "Storage path exists: " . (file_exists($storagePath) ? "YES" : "NO") . "\n";
    
    echo "Public path: {$publicPath}\n";
    echo "Public path exists: " . (file_exists($publicPath) ? "YES" : "NO") . "\n";
    
    echo "Image URL would be: " . asset('storage/artigos/' . $artigo->imagem) . "\n";
} else {
    echo "No articles found in the database.\n";
}
