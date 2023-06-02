<?php

namespace App\Http\Controllers\Grid;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskSpentTimeResource;
use App\Models\TaskSpentTime;
use App\Services\GridComponentHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TaskShowController extends Controller
{
    public function __invoke(GridComponentHandler $handler)
    {
        return response()->json(
            $handler
                ->setResource(TaskSpentTimeResource::class)
                ->setBuilder(
                    TaskSpentTime::query()
                        ->with('task')
                        ->where('task_id', request('task_id'))
                        ->whereHas('task', fn ($query) => $query->where('user_id', Auth::id()))
                )
                ->setSortClosure('date', function (Builder $builder, string $order) {
                    $builder
                        ->orderBy('date', $order)
                        ->orderBy('created_at', $order);
                })
        );
    }
}
