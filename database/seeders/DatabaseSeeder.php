<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/** @used-by \Illuminate\Database\Console\Seeds\SeedCommand::run()
 * @psalm-suppress UnusedClass
 *
 * Главный класс-наполнитель базы данных.
 * Автоматически вызывается:
 *  - При выполнении `php artisan db:seed`
 *  - При запуске тестов с трейтом RefreshDatabase
 *  - При выполнении миграций с флагом --seed
 */
final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @psalm-suppress PossiblyUnusedMethod
     *  Вызывается системой Laravel при выполнении artisan db:seed
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            FilmSeeder::class,
            GenreSeeder::class,
            ActorSeeder::class,
            DirectorSeeder::class,
            CommentSeeder::class,
            FavoriteFilmSeeder::class,
            FilmActorSeeder::class,
            FilmDirectorSeeder::class,
            FilmGenreSeeder::class,
            ]);
    }
}
