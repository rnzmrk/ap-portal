<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PoGppo;

class PoGppoPolicy
{
    public function view(User $user, PoGppo $poGppo): bool
    {
        return
            $user->id === $poGppo->user_id ||
            in_array($user->role, [
                'procurement',
                'finance',
                'operations'
            ]);
    }

    public function update(User $user, PoGppo $poGppo): bool
    {
        // Supplier can edit only while pending

        if (
            $user->role === 'supplier' &&
            $user->id === $poGppo->user_id &&
            $poGppo->status === 'pending'
        ) {
            return true;
        }


        return in_array($user->role, [
            'procurement',
            'finance',
            'operations'
        ]);
    }

    public function edit(User $user, PoGppo $poGppo): bool
    {
        return in_array($user->role, [
            'procurement',
            'finance',
            'operations',
        ]);
    }

    public function delete(User $user, PoGppo $poGppo): bool
    {
        return
            $user->role === 'supplier' &&
            $user->id === $poGppo->user_id &&
            $poGppo->status === 'pending';
    }
}
