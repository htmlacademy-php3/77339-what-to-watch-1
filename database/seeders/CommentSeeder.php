<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @psalm-suppress PossiblyUnusedMethod
     *  Вызывается системой Laravel при выполнении artisan db:seed
     */
    public function run(): void
    {
        $users = User::all();
        $films = Film::all();

        /** @var Collection<int, Comment> $comments */
        $comments = Comment::factory(10)->make();

        $comments->each(function ($comment) use ($users, $films) {
            /** @var User $user */
            $user = $users->random();
            $comment->setAttribute('user_id', $user->id);
            /** @var Film $film */
            $film = $films->random();
            $comment->setAttribute('film_id', $film->id);
            $comment->save();
        });

    }
}
