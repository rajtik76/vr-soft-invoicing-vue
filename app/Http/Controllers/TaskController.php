<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Task', [
            'paginator' => TaskResource::collection(
                Task::withSum('spentTimes', 'time')
                    ->where('user_id', Auth::id())
                    ->paginate()
            ),
        ]);
    }
}
