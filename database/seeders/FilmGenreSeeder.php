<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class FilmGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @psalm-suppress PossiblyUnusedMethod
     *  Вызывается системой Laravel при выполнении artisan db:seed
     */
    public function run(): void
    {
        $genres = Genre::factory()->count(5)->create();

        $films = Film::factory()->count(10)->create();

        /** @psalm-suppress UndefinedMagicMethod */
        $genreIds = $genres->pluck('id')->toArray();
        $genreCount = count($genreIds);

        /** @psalm-suppress UndefinedMagicMethod */
        foreach ($films as $film) {
            $count = min(2, $genreCount);

            $selectedGenreIds = [];
            $availableGenreIds = $genreIds;

            for ($i = 0; $i < $count; $i++) {
                $randomIndex = array_rand($availableGenreIds);
                $selectedGenreIds[] = $availableGenreIds[$randomIndex];
                unset($availableGenreIds[$randomIndex]);
            }

            /** @psalm-suppress UndefinedMagicMethod */
            $film->genres()->syncWithoutDetaching($selectedGenreIds);
        }
    }
}
