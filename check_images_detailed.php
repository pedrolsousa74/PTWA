<?php
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

\ = app();
\ = \->make(Illuminate\Contracts\Http\Kernel::class);
\ = Illuminate\Http\Request::capture();
\->bootstrap();

echo "Checking image paths and URLs:\n\n";

// Get articles with images
\ = App\Models\Artigo::whereNotNull('imagem')->take(3)->get();

if (\->isEmpty()) {
    echo "No articles with images found.\n";
} else {
    echo "Articles with images:\n";
    foreach (\ as \) {
        echo "ID: " . \->id . ", Title: " . \->titulo . ", Image filename: " . \->imagem . "\n";
        
        // Check paths
        \ = public_path('storage/artigos/' . \->imagem);
        \ = storage_path('app/public/artigos/' . \->imagem);
        
        echo "- Storage path exists: " . (file_exists(\) ? 'Yes' : 'No') . "\n";
        echo "- Public path exists: " . (file_exists(\) ? 'Yes' : 'No') . "\n";
        
        // Check URL generation
        \ = asset('storage/artigos/' . \->imagem);
        echo "- URL: " . \ . "\n";
        
        // Check app URL configuration
        echo "- APP_URL config: " . config('app.url') . "\n";
    }
}

// Check symlinks
echo "\nChecking symbolic link:\n";
\ = storage_path('app/public');
\ = public_path('storage');

echo "- Target path exists: " . (file_exists(\) ? 'Yes' : 'No') . "\n";
echo "- Link path exists: " . (file_exists(\) ? 'Yes' : 'No') . "\n";
echo "- Is link: " . (is_link(\) ? 'Yes' : 'No') . "\n";

if (is_link(\)) {
    // Get the target of the link on Windows
    \ = sprintf('dir "%s" | findstr "<SYMLINK>"', \);
    echo "- Link target check: ";
    system(\);
}

// Check if there are any files in the artigos folder
echo "\nFiles in storage/app/public/artigos:\n";
if (is_dir(\ . '/artigos')) {
    \ = scandir(\ . '/artigos');
    foreach (\ as \) {
        if (\ != '.' && \ != '..') {
            echo "- " . \ . " (size: " . filesize(\ . '/artigos/' . \) . " bytes)\n";
        }
    }
} else {
    echo "Directory doesn't exist\n";
}

// Check permissions
echo "\nPermissions:\n";
echo "- app/public permissions: ";
system('icacls "' . \ . '"');
echo "- public/storage permissions: ";
system('icacls "' . \ . '"');

// Check .env APP_URL
echo "\nChecking .env APP_URL:\n";
\ = file_get_contents(__DIR__ . '/.env');
preg_match('/APP_URL=(.*)/', \, \);
if (isset(\[1])) {
    echo "APP_URL in .env: " . \[1] . "\n";
} else {
    echo "APP_URL not found in .env\n";
}
