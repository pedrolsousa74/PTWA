<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artigo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CleanImagesSeeder extends Seeder
{
    /**
     * Clean up missing image references in the database.
     */
    public function run(): void
    {
        $this->command->info('Cleaning up image references in the database...');
        
        // Get all articles with image references
        $artigos = Artigo::whereNotNull('imagem')->get();
        $totalFixed = 0;
        
        foreach ($artigos as $artigo) {
            $storagePath = storage_path('app/public/artigos/' . $artigo->imagem);
            $publicPath = public_path('storage/artigos/' . $artigo->imagem);
            
            if (!file_exists($storagePath) && !file_exists($publicPath)) {
                $this->command->info("Article ID: {$artigo->id}, Title: {$artigo->titulo} - Image not found: {$artigo->imagem}");
                
                // Reset the image reference if the files don't exist
                $artigo->imagem = null;
                $artigo->save();
                $totalFixed++;
            }
        }
        
        $this->command->info("Cleaning complete. Fixed {$totalFixed} articles.");
    }
}
