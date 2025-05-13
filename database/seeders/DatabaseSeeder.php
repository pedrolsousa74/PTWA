<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar um utilizador administrador padrão
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@postit.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Utilizador comum para testes
        User::create([
            'name' => 'Utilizador Teste',
            'email' => 'user@postit.com',
            'password' => \Illuminate\Support\Facades\Hash::make('user123'),
            'is_admin' => false,
        ]);
    }
}
