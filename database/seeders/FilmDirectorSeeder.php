<?php

namespace Database\Seeders;

use App\Models\Director;
use App\Models\Film;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class FilmDirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @psalm-suppress PossiblyUnusedMethod
     *  Вызывается системой Laravel при выполнении artisan db:seed
     */
    public function run(): void
    {
        /** @psalm-suppress UndefinedMagicMethod */
        if (Director::doesntExist()) {
            Director::factory()->count(5)->create();
        }

        /** @psalm-suppress UndefinedMagicMethod */
        if (Film::doesntExist()) {
            Film::factory()->count(10)->create();
        }

        $films = Film::all();
        $directors = Director::all();

        foreach ($films as $film) {
            $directorId = $directors->random()->id;

            $film->directors()->sync([$directorId]);
        }
    }
}
