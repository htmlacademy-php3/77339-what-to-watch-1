<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @psalm-suppress PossiblyUnusedMethod
     *  Вызывается системой Laravel при выполнении artisan db:seed
     */
    public function run(): void
    {
        Film::factory(10)->create();
    }
}
