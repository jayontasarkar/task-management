<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Arr;

class TaskRepository
{
    protected $taskModel;

    public function __construct(Task $task)
    {
        $this->taskModel = $task;
    }

    public function findById($task)
    {
        return $this->taskModel->findOrFail($task);    
    }

    /**
     * Get all tasks for a project
     *
     * @param integer $projectId
     * @return Collection<Task>
     */
    public function forProject($projectId)
    {
        return $this->taskModel->where('project_id', $projectId)->orderBy('priority')->get();
    }

    /**
     * Create a new task
     *
     * @param array $data
     * @return Task
     */
    public function create($data)
    {
        return $this->taskModel->create($data);
    }

    /**
     * Update a task by task id
     *
     * @param integer $taskId
     * @param array $data
     * @return Task
     */
    public function update($taskId, $data)
    {
        $task = $this->taskModel->findOrFail($taskId);

        return $task->update($data);
    }

    /**
     * Delete a task by task id
     *
     * @param integer $taskId
     * @return Task
     */
    public function delete($taskId)
    {
        return $this->taskModel->findOrFail($taskId)->delete();
    }

    /**
     * Sort & reorder priority for tasks
     *
     * @param integer $ids
     * @param array $mapped
     * @return void
     */
    public function sortPriority($ids, $mapped)
    {
        $tasks = $this->taskModel->whereIn('id', $ids)->get();
        $tasks->each(function ($item) use ($mapped) {
            $priority = Arr::first($mapped, function ($value) use ($item) {
                return $value['id'] === $item->id;
            });
            $item->priority = $priority['priority'];
            $item->save();
        });

        return true;
    }
}