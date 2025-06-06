<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

\ = app();
\ = \->make(Illuminate\Contracts\Http\Kernel::class);
\ = Illuminate\Http\Request::capture();
\ = \->handle(\);

// Get a couple of sample articles with images
\ = App\Models\Artigo::whereNotNull('imagem')->take(3)->get(['id', 'titulo', 'imagem']);

echo \
Articles
with
images:\\n\;
foreach (\ as \) {
    echo \ID:
\$artigo->id
Title:
\$artigo->titulo
Image:
\$artigo->imagem
\\n\;
    echo \Full
image
path:
\ . asset('storage/artigos/' . \->imagem) . \\\n\;
    echo \Image
file
exists:
\ . (file_exists(public_path('storage/artigos/' . \->imagem)) ? 'Yes' : 'No') . \\\n\;
    echo \Original
file
exists:
\ . (file_exists(storage_path('app/public/artigos/' . \->imagem)) ? 'Yes' : 'No') . \\\n\;
    echo \-----------------------------------\\n\;
}

// Now check if there are any articles without images
\ = App\Models\Artigo::count();
\ = App\Models\Artigo::whereNull('imagem')->count();

echo \\\nTotal
articles:
\$totalArtigos
\\n\;
echo \Articles
without
images:
\$noImageArtigos
\\n\;


