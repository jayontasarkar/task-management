<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function show(User $user, Project $project)
    {
        return $user->id === $project->user_id;
    }

    public function destroy(User $user, Project $project)
    {
        return $project->user_id === $user->id;
    }
}
