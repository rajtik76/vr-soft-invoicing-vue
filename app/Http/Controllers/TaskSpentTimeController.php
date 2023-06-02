<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSpentTimeRequest;
use App\Http\Resources\TaskSpentTimeResource;
use App\Models\Task;
use App\Models\TaskSpentTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TaskSpentTimeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('TaskSpentTime/Index');
    }

    public function edit(TaskSpentTime $taskSpentTime): Response
    {
        if (!Auth::user()->can('update', $taskSpentTime)) {
            abort(403);
        }

        return Inertia::render('TaskSpentTime/Edit', [
            'taskSpentTime' => TaskSpentTimeResource::make($taskSpentTime),
            'tasks' => $this->getTaskOptionsArray()
        ]);
    }

    public function update(TaskSpentTime $taskSpentTime, TimeSpentTimeRequest $request): RedirectResponse
    {
        if (!Auth::user()->can('update', $taskSpentTime)) {
            abort(403);
        }

        $taskSpentTime->update($request->validated());

        return to_route('task.show', $taskSpentTime->task_id)->with('success', "TaskSpentTime record from {$taskSpentTime->date->toDateString()} for task {$taskSpentTime->task->name} was successfully updated");
    }

    public function create(): Response
    {
        $timeRecord = new TaskSpentTime(['date' => now()]);

        if (request()->get('task_id')) {
            $task = Task::findOrFail(request('task_id'));

            if (!Auth::user()->can('update', $task)) {
                abort(403);
            }

            $timeRecord->task_id = $task->id;
        }

        return Inertia::render('TaskSpentTime/Create', [
            'taskSpentTime' => TaskSpentTimeResource::make($timeRecord),
            'tasks' => $this->getTaskOptionsArray()
        ]);
    }

    public function store(TimeSpentTimeRequest $request): RedirectResponse
    {
        $taskSpentTime = TaskSpentTime::create($request->validated());

        return to_route('task.show', $taskSpentTime->task_id)->with('success', "Time log with amount {$taskSpentTime->time} hours for task {$taskSpentTime->task->name} was successfully created");
    }

    public function destroy(TaskSpentTime $taskSpentTime): RedirectResponse
    {
        $hours = $taskSpentTime->time;

        $taskSpentTime->delete();

        return back()->with('success', "Time log with amount {$hours} was successfully deleted");
    }

    protected function getTaskOptionsArray(): array
    {
        return Task::where('user_id', Auth::id())
            ->where('active', true)
            ->pluck('name', 'id')
            ->toArray();
    }
}
