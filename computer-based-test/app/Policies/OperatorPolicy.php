<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Operator; 
use Illuminate\Auth\Access\HandlesAuthorization;

class OperatorPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Operator $operator)
    {
        return $user->hasRole('Admin');
    }

    public function edit(User $user, Operator $operator)
    {
    return $user->hasRole('Admin');
    }
}