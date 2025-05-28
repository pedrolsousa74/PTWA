<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class TestEmailCommand extends Command
{
    protected $signature = 'email:test {email}';
    protected $description = 'Test email sending';

    public function handle()
    {
        $email = $this->argument('email');
        
        try {
            Mail::to($email)->send(new TestMail());
            $this->info("Email enviado com sucesso para $email!");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Erro ao enviar email: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
