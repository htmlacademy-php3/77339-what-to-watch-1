<?php

namespace App\Policies;

use App\Models\Film;
use App\Models\User;

class FilmPolicy
{
    public function editResource(User $user, Film $film): bool
    {
        return $user->isModerator();
    }
} 