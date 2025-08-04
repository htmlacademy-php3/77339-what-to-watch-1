<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function editResource(User $user, Comment $comment): bool
    {
        return $user->isModerator();
    }
} 