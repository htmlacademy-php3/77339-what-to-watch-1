<?php

namespace App\Policies;

use App\Models\Genre;
use App\Models\User;

class GenrePolicy
{
    /**
     * Determine whether the user can edit the genre.
     */
    public function editResource(User $user, Genre $genre): bool
    {
        return $user->isModerator();
    }
} 