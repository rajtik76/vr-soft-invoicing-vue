<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskSpentTimeResource;
use App\Models\TaskSpentTime;
use App\Services\GridComponentHandler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TimeController extends Controller
{
    public function index(GridComponentHandler $handler): Response
    {
        return Inertia::render('Time/Index', [
            'times' => $handler
                ->setResource(TaskSpentTimeResource::class)
                ->setBuilder(
                    TaskSpentTime::with('task')
                        ->whereHas('task', fn ($query) => $query->where('user_id', Auth::id()))
                )
        ]);
    }

    public function edit(TaskSpentTime $time): Response
    {
        return Inertia::render('Time/Edit', [
            'time' => $time,
        ]);
    }

    public function destroy(TaskSpentTime $time): RedirectResponse
    {
        $hours = $time->time;

        return to_route('time.index')->with('success', "Time log with amount {$hours} was successfully deleted");
    }
}
