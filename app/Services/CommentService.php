<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Collection;

class CommentService
{
    public function getFilmComments(int $filmId): Collection
    {
        return Comment::with('user')
            ->where('film_id', $filmId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function (Comment $comment) {
                return [
                    'text' => $comment->text,
                    'author' => $comment->user?->name ?? 'Гость',
                    'created_at' => $comment->created_at->toDateTimeString(),
                    'rate' => $comment->rate,
                ];
            });
    }

    public function addComment(User $user, Movie $movie, string $text): Comment
    {
        return Comment::create([
            'user_id'  => $user->id,
            'movie_id' => $movie->id,
            'text'     => $text,
        ]);
    }

    public function getComments(Movie $movie)
    {
        return $movie->comments()->with('user')->latest()->get();
    }

    public function deleteComment(Comment $comment, User $user): void
    {
        if ($comment->user_id !== $user->id) {
            abort(403);
        }

        $comment->delete();
    }
}
