<?php

declare(strict_types=1);

namespace App\Http\Controllers\Grid;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskSpentTimeResource;
use App\Models\TaskSpentTime;
use App\Services\GridComponentHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskSpentTimesController extends Controller
{
    public function __invoke(GridComponentHandler $handler): JsonResponse
    {
        return response()->json(
            $handler
                ->setResource(TaskSpentTimeResource::class)
                ->setBuilder(
                    TaskSpentTime::query()
                        ->with('task')
                        ->where('user_id', Auth::id())
                )
        );
    }
}
