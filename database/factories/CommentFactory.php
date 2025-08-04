<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence(),
            'author' => $this->faker->name(),
            'rate' => $this->faker->numberBetween(1, 10),
            'comment_id' => null,
            'user_id' => \App\Models\User::factory(),
            'film_id' => \App\Models\Film::factory(),
        ];
    }
}
