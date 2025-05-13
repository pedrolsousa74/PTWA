<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um utilizador administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?: 'admin@postit.com';
        $password = $this->argument('password') ?: 'admin123';
          // Verificar se o utilizador já existe
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            // Atualizar utilizador existente para ser administrador
            $existingUser->is_admin = true;
            $existingUser->password = Hash::make($password);
            $existingUser->save();
            
            $this->info("Utilizador {$email} atualizado para administrador com sucesso!");
        } else {
            // Criar novo utilizador administrador
            User::create([
                'name' => 'Administrador',
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]);
            
            $this->info("Utilizador administrador criado com sucesso!");
        }
        
        $this->info("Email: {$email}");
        $this->info("Senha: {$password}");
    }
}
