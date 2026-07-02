<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(['quero_ler', 'lendo', 'lido']);

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'genre' => fake()->randomElement(['Ficção', 'Não-ficção', 'Fantasia', 'Biografia', 'Tecnologia']),
            'status' => $status,
            'rating' => $status === 'lido' ? fake()->numberBetween(1, 5) : null,
            'notes' => fake()->optional()->sentence(10),
            'pages' => fake()->numberBetween(80, 900),
        ];
    }
}