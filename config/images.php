<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Generic Images Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for generic images used in the system
    | when no specific image is provided by the user.
    |
    */

    'generic' => [        // Path where the generic images are stored
        'path' => 'Icones',
        
        // Default image to use when all else fails
        'default' => 'post-it.png',
        
        // Images that can be used as generic images for articles
        'available' => [
            ['post-it', 'png'],
            // Estas imagens não serão mais usadas como genéricas, mas mantidas como referência
            // ['artigo1', 'jpg'],
            // ['artigo2', 'jpeg'],
            // ['artigo3', 'png'],
            // ['artigo4', 'jpeg'],
            // ['Lampada', 'png'],
            // ['lampada', 'webp'],
            // ['Escrever', 'webp'],
            // Adicione novas imagens aqui
        ],
    ],
];
