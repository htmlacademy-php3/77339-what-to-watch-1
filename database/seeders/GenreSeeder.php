<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @psalm-suppress PossiblyUnusedMethod
     *  Вызывается системой Laravel при выполнении artisan db:seed
     */
    public function run(): void
    {
        $genres = [
            'Drama', 'Comedy', 'Action', 'Sci-Fi', 'Horror',
            'Romance', 'Thriller', 'Documentary', 'Adventure', 'Animation'
        ];

        foreach ($genres as $genreName) {
            Genre::firstOrCreate(['name' => $genreName]);
        }
    }
}
