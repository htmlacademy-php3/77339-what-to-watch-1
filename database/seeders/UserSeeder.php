<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * @used-by DatabaseSeeder::run()
 * @psalm-suppress UnusedClass
 * @psalm-suppress PossiblyUndefinedMethod
 * */
final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @psalm-suppress PossiblyUnusedMethod
     * Вызывается системой Laravel при выполнении artisan db:seed
     */
    public function run(): void
    {
        User::factory(10)->create();
    }
}
