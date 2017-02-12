<?php

namespace App\Policies\Todo;

use App\Models\User\User;
use App\Models\Todo\Todo;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the todo.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Todo\Todo  $todo
     * @return mixed
     */
    public function update(User $user, Todo $todo)
    {
        return $todo->user->id == auth()->user()->id;
    }

    /**
     * Determine whether the user can delete the todo.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Todo\Todo  $todo
     * @return mixed
     */
    public function delete(User $user, Todo $todo)
    {
        return $todo->user->id == auth()->user()->id;
    }
}
