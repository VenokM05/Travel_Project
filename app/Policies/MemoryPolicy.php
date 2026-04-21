<?php

namespace App\Policies;

use App\Models\Memory;
use App\Models\User;

class MemoryPolicy
{
    /**
     * Determine if the user can update the memory.
     */
    public function update(User $user, Memory $memory): bool
    {
        return $user->id === $memory->user_id;
    }

    /**
     * Determine if the user can delete the memory.
     */
    public function delete(User $user, Memory $memory): bool
    {
        return $user->id === $memory->user_id;
    }
}
