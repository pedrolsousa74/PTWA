<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordMail;
use App\Models\User;

class TestPasswordReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:password-reset {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testar a funcionalidade de redefinição de palavra-passe';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();        if (!$user) {
            $this->error("Utilizador com e-mail {$email} não encontrado.");
            return Command::FAILURE;
        }

        // Gerar token
        $token = Str::random(64);
        
        // Armazenar token no banco de dados
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => $token,
                'created_at' => now()
            ]
        );

        // Gerar link de recuperação
        $resetLink = url(route('password.reset', [
            'token' => $token, 
            'email' => $email
        ], false));        $this->line("Link de redefinição de palavra-passe:");
        $this->info($resetLink);        // Enviar email ou simular o envio
        try {
            // Forçar o uso do log driver para teste
            config(['mail.mailer' => 'log']);
            
            Mail::to($email)->send(new ResetPasswordMail($token, $email));
            $this->info("Email enviado com sucesso para {$email}!");
            $this->line("O e-mail foi enviado usando o driver 'log'. Verifique storage/logs/laravel.log para mais detalhes.");
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Erro ao enviar email: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
