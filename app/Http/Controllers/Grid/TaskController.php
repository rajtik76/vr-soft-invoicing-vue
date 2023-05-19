<?php

namespace App\Http\Controllers\Grid;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskIndexResource;
use App\Models\Task;
use App\Services\GridComponentHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    public function __invoke(GridComponentHandler $handler)
    {
        return response()->json(
            $handler
                ->setResource(TaskIndexResource::class)
                ->setBuilder(Task::query()
                    ->with('contract.customer')
                    ->withSum('spentTimes', 'time')
                    ->where('user_id', Auth::id())
                    ->where('active', Session::get('task.active', true)))
        );
    }
}
