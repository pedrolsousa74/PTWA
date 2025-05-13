<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar se já existe um utilizador com este e-mail
        $existingUser = User::where('email', 'admin@postit.com')->first();

        if ($existingUser) {            // Atualizar o utilizador existente para ser admin
            $existingUser->is_admin = true;
            $existingUser->save();
            echo "Utilizador admin existente atualizado para ter permissões de administrador!\n";
        } else {
            // Inserir diretamente usando DB para garantir que os valores são inseridos corretamente
            DB::table('users')->insert([
                'name' => 'Administrador',
                'email' => 'admin@postit.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            echo "Utilizador administrador criado com sucesso!\n";
        }        // Verificar se o utilizador admin foi criado corretamente
        $adminUser = User::where('email', 'admin@postit.com')->first();
        if ($adminUser && $adminUser->is_admin) {
            echo "Confirmado: Utilizador admin existe e tem permissões de administrador.\n";
        } else {
            echo "ATENÇÃO: Problemas ao criar ou atualizar o usuário admin!\n";
        }
    }
}
