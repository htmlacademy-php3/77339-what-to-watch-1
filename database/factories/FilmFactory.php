<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'year' => $this->faker->year(),
            'description' => $this->faker->paragraph(),
            'director' => $this->faker->name(),
            'actors' => $this->faker->name() . ', ' . $this->faker->name(),
            'duration' => (string) $this->faker->numberBetween(80, 180),
            'imdb_rating' => $this->faker->randomFloat(1, 1, 10),
            'imdb_votes' => $this->faker->numberBetween(100, 100000),
            'imdb_id' => $this->faker->unique()->regexify('tt[0-9]{7}'),
            'poster_url' => $this->faker->imageUrl(),
            'preview_url' => $this->faker->imageUrl(),
            'background_color' => $this->faker->hexColor(),
            'cover_url' => $this->faker->imageUrl(),
            'video_url' => $this->faker->url(),
            'video_preview_url' => $this->faker->url(),
        ];
    }
}
