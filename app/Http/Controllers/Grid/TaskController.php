<?php

namespace App\Http\Controllers\Grid;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskIndexResource;
use App\Models\Task;
use App\Services\GridComponentHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __invoke(GridComponentHandler $handler)
    {
        return response()->json(
            $handler
                ->setResource(TaskIndexResource::class)
                ->setBuilder(
                    Task::query()
                        ->with('contract.customer')
                        ->withSum('spentTimes', 'time')
                        ->where('user_id', Auth::id())
                )
                ->setFilterClosure('customer', function (Builder $builder, string $value) {
                    $builder->where('contract_id', $value);
                })
        );
    }
}
