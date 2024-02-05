<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use App\Services\PriorityService;

class TaskController extends Controller
{
    protected $taskRepo;

    protected $projectRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $taskRepo, ProjectRepository $projectRepo)
    {
        $this->middleware('auth');
        $this->taskRepo = $taskRepo;
        $this->projectRepo = $projectRepo;
    }

    /**
     * Render view for tasks of a project
     *
     * @return void
     */
    public function render($project)
    {
        $project = $this->projectRepo->findOne($project);
        $this->authorize('show', $project);

        $projects = $this->projectRepo->forUser(auth()->id());

        return view('tasks.index', [
            'project' => $project,
            'projects' => $projects
        ]);
    }

    /**
     * Get all tasks by project
     *
     * @param integer $project
     * @return void
     */
    public function index($project)
    {
        $this->authorize('show', $this->projectRepo->findOne($project));

        $task = $this->taskRepo->forProject($project);
        
        return TaskResource::collection($task);
    }

    /**
     * Store a new task
     *
     * @param TaskRequest $request
     * @return void
     */
    public function store(TaskRequest $request)
    {
        $task = $this->taskRepo->create([
            'project_id' => $request->project_id,
            'name' => $request->name,
            'priority' => PriorityService::setPriorityFor($request->project_id)
        ]);

        return new TaskResource($task);
    }

    /**
     * Update a task
     *
     * @param TaskRequest $request
     * @param integer $task
     * @return void
     */
    public function update(TaskRequest $request, $task)
    {
        $this->authorize('update', $this->taskRepo->findById($task));

        $task = $this->taskRepo->update($task, [
            'name' => $request->name
        ]);
        
        return response()->json([
            'message' => 'Task updated!'
        ]);
    }

    /**
     * Delete a task
     *
     * @param integer $task
     * @return void
     */
    public function destroy($task)
    {
        $task = $this->taskRepo->findById($task);
        $this->authorize('destroy', $task);

        $task->delete($task);

        return response()->json([
            'message' => 'Task deleted'
        ]);
    }
}
