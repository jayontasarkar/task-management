<?php

namespace App\Services;

use App\Models\Task;

class PriorityService {
    public static function setPriorityFor($project) {
        $lessPriorityTask = Task::where('project_id', $project)
                ->orderBy('priority', 'DESC')
                ->first();

        return $lessPriorityTask ? $lessPriorityTask->priority + 1 : 1;
    }
}