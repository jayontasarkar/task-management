<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Task $task)
    {
        return $user->id === $task->project->user_id;
    }

    public function destroy(User $user, Task $task)
    {
        return $user->id === $task->project->user_id;
    }
}
