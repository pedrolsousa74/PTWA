<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para verificar se um utilizador pode fazer login.
     */
    public function testUserCanLogin(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Teste para verificar se um utilizador é redirecionado se as credenciais forem inválidas.
     */
    public function testUserCannotLoginWithInvalidCredentials(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Teste para verificar se um utilizador pode registar-se.
     */
    public function testUserCanRegister(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Teste para verificar se um utilizador pode fazer logout.
     */
    public function testUserCanLogout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Teste para verificar se a página de recuperação de password está acessível.
     */
    public function testPasswordRequestPageLoads(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Recuperar Password');
    }

    /**
     * Teste para verificar se um token de redefinição de password é gerado.
     */
    public function testPasswordResetTokenIsGenerated(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $this->post('/forgot-password', [
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Teste para verificar se um utilizador pode redefinir a sua password.
     */
    public function testUserCanResetPassword(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        // Gerar token manualmente para teste
        $token = 'test-token';
        DB::table('password_reset_tokens')->insert([
            'email' => 'test@example.com',
            'token' => $token,
            'created_at' => now(),
        ]);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'test@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect('/login');
        
        // Verificar se a nova password funciona
        $this->assertTrue(Hash::check('new-password', User::where('email', 'test@example.com')->first()->password));
        
        // Verificar se o token foi eliminado
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => 'test@example.com',
        ]);
    }
}
