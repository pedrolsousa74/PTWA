<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurar o broker de redefinição de senha
        $this->app->singleton('auth.password', function ($app) {
            return new PasswordBrokerManager($app);
        });
        
        // Configurar as funcionalidades do Laravel para usar o email
        $this->app->config->set('mail.default', env('MAIL_MAILER', 'smtp'));
        
        // Verificar e forçar a criação do log se ele não existir
        if (!file_exists(storage_path('logs/laravel.log'))) {
            file_put_contents(storage_path('logs/laravel.log'), '');
        }
    }
}
