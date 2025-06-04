<?php

namespace Database\Factories;

use App\Models\Artigo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtigoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Artigo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categorias = ['tecnologia', 'ambiente', 'educacao', 'outros'];
        
        return [
            'titulo' => $this->faker->sentence(),
            'subtitulo' => $this->faker->sentence(),
            'conteudo' => $this->faker->paragraphs(3, true),
            'categoria' => $this->faker->randomElement($categorias),
            'user_id' => User::factory(),
        ];
    }
}
