<?php

namespace Tests\Unit;

use App\Models\Artigo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtigoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para verificar a criação de um artigo.
     */
    public function testArtigoCreation(): void
    {
        $user = User::factory()->create();

        $artigo = Artigo::create([
            'titulo' => 'Teste de Artigo',
            'subtitulo' => 'Um subtítulo de teste',
            'conteudo' => 'Este é o conteúdo do artigo de teste',
            'categoria' => 'tecnologia',
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Artigo::class, $artigo);
        $this->assertEquals('Teste de Artigo', $artigo->titulo);
        $this->assertEquals('Um subtítulo de teste', $artigo->subtitulo);
        $this->assertEquals('tecnologia', $artigo->categoria);
        $this->assertEquals($user->id, $artigo->user_id);
        $this->assertDatabaseHas('artigos', [
            'titulo' => 'Teste de Artigo',
        ]);
    }

    /**
     * Teste para verificar a relação entre artigo e utilizador.
     */
    public function testArtigoUserRelationship(): void
    {
        $user = User::factory()->create();
        
        $artigo = Artigo::create([
            'titulo' => 'Teste de Artigo',
            'subtitulo' => 'Um subtítulo de teste',
            'conteudo' => 'Este é o conteúdo do artigo de teste',
            'categoria' => 'tecnologia',
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $artigo->user);
        $this->assertEquals($user->id, $artigo->user->id);
    }

    /**
     * Teste para verificar os métodos que formatam as datas dos artigos.
     */
    public function testArtigoDateFormatting(): void
    {
        $user = User::factory()->create();
        
        $artigo = Artigo::create([
            'titulo' => 'Teste de Artigo',
            'subtitulo' => 'Um subtítulo de teste',
            'conteudo' => 'Este é o conteúdo do artigo de teste',
            'categoria' => 'tecnologia',
            'user_id' => $user->id,
        ]);

        // Verifica se a data de criação é formatada corretamente
        $this->assertNotEmpty($artigo->created_at);
        $this->assertIsString($artigo->created_at->format('d/m/Y'));
    }
}
