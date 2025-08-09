<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 *
 * @psalm-suppress UnusedClass
 *  Класс используется через вызов в DatabaseSeeder
 */
final class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return (Factory|int|null|string)[]
     *
     * @psalm-return array{text: string, user_id: Factory, film_id: Factory, rate: int, comment_id: null}
     */
    #[\Override]
    public function definition(): array
    {
        return [
            'text' => fake()->sentence(2, true),
            'user_id' => User::factory(),
            'film_id' => Film::factory(),
            'rate' => $this->faker->numberBetween(1, 10),
            'comment_id' => null,
        ];
    }
}
