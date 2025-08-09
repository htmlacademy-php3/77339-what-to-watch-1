<?php

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @psalm-suppress PossiblyUnusedMethod
     * Вызывается системой Laravel при выполнении artisan db:seed
     */
    public function run(): void
    {
        Actor::factory(10)->create();
    }
}
