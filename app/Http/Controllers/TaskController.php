<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Contract;
use App\Models\Task;
use App\Models\TaskSpentTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Task/Index', [
            'contracts' => Arr::add(
                array: Contract::all()
                    ->mapWithKeys(fn (Contract $contract, $key) => [$contract->id => $contract->customer->name])
                    ->toArray(),
                key: '',
                value: 'All'
            )
        ]);
    }

    public function show(Task $task): Response
    {
        return Inertia::render('Task/Show', [
            'task' => TaskResource::make($task),
            'hours' => TaskSpentTime::where('task_id', $task->id)->sum('time')
        ]);
    }

    public function edit(Task $task): Response
    {
        // only task owner can edit
        if (!Auth::user()->can('view', $task)) {
            abort(403);
        }

        return Inertia::render('Task/Edit', [
            'task' => TaskResource::make($task),
            'contracts' => $this->getContracts(),
        ]);
    }

    protected function getContracts(): array
    {
        return Contract::with('customer')
            ->get()
            ->mapWithKeys(fn (Contract $contract) => [$contract->id => $contract->number . ' - ' . $contract->customer->name])
            ->all();
    }

    public function update(Task $task, TaskRequest $request): RedirectResponse
    {
        $task->update($request->validated());

        return to_route('task.index')->with('success', 'Task `' . $task->name . '` successfully updated');
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        Task::create($validated);

        return to_route('task.index')->with('success', 'Task successfully created');
    }

    public function create(): Response
    {
        return Inertia::render('Task/Create', [
            'task' => TaskResource::make(new Task(['active' => true])),
            'contracts' => $this->getContracts(),
        ]);
    }

    public function destroy(Task $task): RedirectResponse
    {
        if (!Auth::user()->can('delete', $task)) {
            abort(403);
        }

        $taskName = $task->name;
        $task->delete();

        return to_route('task.index')->with('success', 'Task `' . $taskName . '` was successfully deleted');
    }
}
