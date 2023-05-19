<?php

namespace App\Http\Controllers\Grid;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskSpentTimeResource;
use App\Models\TaskSpentTime;
use App\Services\GridComponentHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskSpentTimeController extends Controller
{
    public function __invoke(GridComponentHandler $handler): JsonResponse
    {
        return response()->json(
            $handler
                ->setResource(TaskSpentTimeResource::class)
                ->setBuilder(
                    TaskSpentTime::query()
                    ->with('task')
                    ->whereHas(
                        'task',
                        fn ($query) => $query->where('user_id', Auth::id())
                    )
                )
        );
    }
}
