<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JoEvaluation;

class JoEvaluationPolicy
{
    public function view(
        User $user,
        JoEvaluation $joEvaluation
    ): bool {

        return
            $user->id === $joEvaluation->user_id ||
            in_array($user->role, [
                'procurement',
                'finance',
                'operations'
            ]);
    }

    public function update(
        User $user,
        JoEvaluation $joEvaluation
    ): bool {

        if (
            $user->role === 'supplier' &&
            $user->id === $joEvaluation->user_id &&
            $joEvaluation->status === 'pending'
        ) {
            return true;
        }

        return in_array($user->role, [
            'procurement',
            'finance',
            'operations'
        ]);
    }

    public function edit(
        User $user,
        JoEvaluation $joEvaluation
    ): bool {
        // Only procurement, finance, operations can edit
        return in_array($user->role, [
            'procurement',
            'finance',
            'operations'
        ]);
    }

    public function delete(
        User $user,
        JoEvaluation $joEvaluation
    ): bool {
        // Only procurement, finance, operations can delete
        return in_array($user->role, [
            'procurement',
            'finance',
            'operations'
        ]);
    }
}
