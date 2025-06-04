<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;    /**
     * Teste para verificar se um administrador pode acessar o painel admin.
     */
    public function testAdminCanAccessAdminDashboard(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
    }    /**
     * Teste para verificar se um utilizador normal não pode acessar o painel admin.
     */
    public function testRegularUserCannotAccessAdminDashboard(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403); // Forbidden
    }    /**
     * Teste para verificar se um utilizador não autenticado não pode acessar o painel admin.
     */
    public function testUnauthenticatedUserCannotAccessAdminDashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    /**
     * Teste para verificar se a página de configuração do admin está acessível.
     */
    public function testAdminSetupPageIsAccessible(): void
    {
        $response = $this->get('/admin/setup');

        $response->assertStatus(200);
        $response->assertSee('Configuração de Administrador');
    }

    /**
     * Teste para verificar o endpoint de verificação de status de administrador.
     */
    public function testAdminCheckEndpoint(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/check');

        $response->assertStatus(200);
        $response->assertJson([
            'is_admin_raw' => true,
            'is_admin_method' => true,
        ]);

        $regularUser = User::factory()->create([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($regularUser)->get('/admin/check');

        $response->assertStatus(200);
        $response->assertJson([
            'is_admin_raw' => false,
            'is_admin_method' => false,
        ]);
    }
}
