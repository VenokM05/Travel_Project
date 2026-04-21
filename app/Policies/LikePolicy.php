<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;

class LikePolicy
{
    /**
     * Determine if the user can delete the like.
     */
    public function delete(User $user, Like $like): bool
    {
        return $user->id === $like->user_id;
    }
}
