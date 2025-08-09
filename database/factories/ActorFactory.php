<?php

namespace Database\Factories;

use App\Models\Actor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Actor>
 *
 * @psalm-suppress UnusedClass
 *  Класс используется через вызов в DatabaseSeeder
 */
final class ActorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return string[]
     *
     * @psalm-return array{name: string}
     */
    #[\Override]
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
