<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Film;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class FilmActorSeeder extends Seeder
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
        if (Actor::doesntExist()) {
            Actor::factory()->count(10)->create();
        }

        /** @psalm-suppress UndefinedMagicMethod */
        if (Film::doesntExist()) {
            Film::factory()->count(5)->create();
        }

        $films = Film::all();
        $actors = Actor::all();

        if ($actors->isEmpty()) {
            throw new \RuntimeException('No actors available to attach to films');
        }

        foreach ($films as $film) {
            $count = rand(1, min(5, $actors->count()));

            /** @psalm-suppress UndefinedMagicMethod */
            $randomActorIds = $actors->random($count)->pluck('id');

            $film->actors()->syncWithoutDetaching($randomActorIds);
        }
    }
}
