<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para verificar se um utilizador pode ser criado corretamente.
     */
    public function testUserCreation(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Teste para verificar se a função isAdmin funciona corretamente.
     */
    public function testIsAdminFunction(): void
    {
        // Criar um utilizador normal
        $regularUser = User::factory()->create([
            'is_admin' => false
        ]);
        
        // Criar um administrador
        $adminUser = User::factory()->create([
            'is_admin' => true
        ]);

        $this->assertFalse($regularUser->isAdmin());
        $this->assertTrue($adminUser->isAdmin());
    }

    /**
     * Teste para verificar a relação entre utilizador e artigos.
     */
    public function testUserArticlesRelationship(): void
    {
        $user = User::factory()->create();
        
        // Verifica se o método 'artigos' existe e retorna uma coleção
        $this->assertIsIterable($user->artigos);
    }
}
