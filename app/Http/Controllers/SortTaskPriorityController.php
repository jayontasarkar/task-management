<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Repositories\TaskRepository;

class SortTaskPriorityController extends Controller
{
    protected $taskRepo;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->middleware('auth');
        $this->taskRepo = $taskRepo;
    }

    public function __invoke(Request $request)
    {
        $mapped = $request->mapped;
        $ids = Arr::pluck($mapped, 'id');
        $this->taskRepo->sortPriority($ids, $mapped);

        return response()->json([
            'message' => 'Task sorted successfully'
        ]);
    }
}
