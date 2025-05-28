<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar utilizador administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@postit.pt',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);
        
        $this->command->info('Utilizador administrador criado com sucesso!');
        $this->command->info('Email: admin@postit.pt');
        $this->command->info('Palavra-passe: admin123');
    }
}
