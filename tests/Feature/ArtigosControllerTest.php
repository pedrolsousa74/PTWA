<?php

namespace Tests\Feature;

use App\Models\Artigo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtigosControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para verificar se a página de artigos carrega corretamente.
     */
    public function testArtigosPageLoads(): void
    {
        $response = $this->get('/artigos');

        $response->assertStatus(200);
        $response->assertViewIs('artigos');
    }

    /**
     * Teste para verificar se um artigo específico pode ser visualizado.
     */
    public function testSingleArtigoPageLoads(): void
    {
        $user = User::factory()->create();
        
        $artigo = Artigo::create([
            'titulo' => 'Teste de Artigo',
            'subtitulo' => 'Um subtítulo de teste',
            'conteudo' => 'Este é o conteúdo do artigo de teste',
            'categoria' => 'tecnologia',
            'user_id' => $user->id,
        ]);

        $response = $this->get("/artigos/{$artigo->id}");

        $response->assertStatus(200);
        $response->assertSee('Teste de Artigo');
    }

    /**
     * Teste para verificar se um utilizador autenticado pode criar um artigo.
     */
    public function testAuthenticatedUserCanCreateArtigo(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/artigos', [
            'titulo' => 'Novo Artigo de Teste',
            'subtitulo' => 'Um novo subtítulo de teste',
            'conteudo' => 'Este é o conteúdo do novo artigo de teste',
            'categoria' => 'educacao',
        ]);

        // Redirecionamento após criação bem-sucedida
        $response->assertStatus(302);
        
        $this->assertDatabaseHas('artigos', [
            'titulo' => 'Novo Artigo de Teste',
            'user_id' => $user->id,
        ]);
    }

    /**
     * Teste para verificar se um utilizador não autenticado não pode criar um artigo.
     */
    public function testUnauthenticatedUserCannotCreateArtigo(): void
    {
        $response = $this->post('/artigos', [
            'titulo' => 'Novo Artigo de Teste',
            'subtitulo' => 'Um novo subtítulo de teste',
            'conteudo' => 'Este é o conteúdo do novo artigo de teste',
            'categoria' => 'educacao',
        ]);

        // Deve redirecionar para a página de login
        $response->assertRedirect('/login');
        
        $this->assertDatabaseMissing('artigos', [
            'titulo' => 'Novo Artigo de Teste',
        ]);
    }

    /**
     * Teste para verificar se um utilizador autenticado pode editar seu próprio artigo.
     */
    public function testUserCanEditOwnArtigo(): void
    {
        $user = User::factory()->create();
        
        $artigo = Artigo::create([
            'titulo' => 'Teste de Artigo',
            'subtitulo' => 'Um subtítulo de teste',
            'conteudo' => 'Este é o conteúdo do artigo de teste',
            'categoria' => 'tecnologia',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get("/artigos/{$artigo->id}/editar");
        $response->assertStatus(200);

        $updateResponse = $this->actingAs($user)->put("/artigos/{$artigo->id}", [
            'titulo' => 'Título Atualizado',
            'subtitulo' => 'Subtítulo atualizado',
            'conteudo' => 'Conteúdo atualizado',
            'categoria' => 'ambiente',
        ]);

        $updateResponse->assertStatus(302); // Redirecionamento após atualização
        
        $this->assertDatabaseHas('artigos', [
            'id' => $artigo->id,
            'titulo' => 'Título Atualizado',
            'categoria' => 'ambiente',
        ]);
    }

    /**
     * Teste para verificar se um utilizador não pode editar artigos de outros utilizadores.
     */
    public function testUserCannotEditOtherUsersArtigos(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $artigo = Artigo::create([
            'titulo' => 'Teste de Artigo',
            'subtitulo' => 'Um subtítulo de teste',
            'conteudo' => 'Este é o conteúdo do artigo de teste',
            'categoria' => 'tecnologia',
            'user_id' => $user1->id,
        ]);

        $response = $this->actingAs($user2)->get("/artigos/{$artigo->id}/editar");
        
        // Deve ser redirecionado com erro
        $response->assertStatus(302);
        $response->assertSessionHas('error');
    }
}
