<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class FavoriteFilmSeeder extends Seeder
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
        if (User::count() === 0) {
            User::factory()->count(5)->create();
        }

        /** @psalm-suppress UndefinedMagicMethod */
        if (Film::count() === 0) {
            Film::factory()->count(10)->create();
        }

        $users =
            User::all();
        $films =
            Film::all();

        if ($films->isEmpty()) {
            $films =
                Film::factory()->count(10)->create();
        }

        /** @psalm-suppress UndefinedMagicMethod */
        foreach ($users as $user) {
            $count = rand(1, min(5, $films->count()));

            /** @psalm-suppress UndefinedMagicMethod */
            $randomFilmIds = $films->random($count)->pluck('id');

            $user->favoriteFilms()->syncWithoutDetaching($randomFilmIds);
        }
    }
}
