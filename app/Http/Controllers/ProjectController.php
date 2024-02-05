<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectRepo;
    protected $taskRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProjectRepository $projectRepo)
    {
        $this->middleware('auth');
        $this->projectRepo = $projectRepo;
    }

    public function index(Request $request)
    {
        $projects = $this->projectRepo->forUser(auth()->id());
        $projects->load('tasks');

        return ProjectResource::collection($projects);
    }

    public function store(ProjectRequest $request)
    {
        $project = $this->projectRepo->create([
            'name' => $request->name,
            'user_id' => auth()->id()
        ]);

        return new ProjectResource($project);
    }

    public function destroy($project)
    {
        $this->authorize('destroy', $this->projectRepo->findOne($project));

        $this->projectRepo->delete($project);

        return response()->json([
            'message' => 'Project removed successfully!'
        ]);
    }
}
