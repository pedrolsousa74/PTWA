<?php

namespace Database\Factories;

use App\Models\Artigo;
use App\Models\Comentario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComentarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comentario::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'conteudo' => $this->faker->paragraph(),
            'user_id' => User::factory(),
            'artigo_id' => Artigo::factory(),
        ];
    }
}
