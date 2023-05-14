<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\ContractWithCustomerOptionsResource;
use App\Http\Resources\TaskIndexResource;
use App\Http\Resources\TaskResource;
use App\Models\Contract;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Task/Index', [
            'paginator' => TaskIndexResource::collection(
                Task::with('contract')
                    ->withSum('spentTimes', 'time')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10)
            ),
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

    protected function getContracts(): JsonResource
    {
        return ContractWithCustomerOptionsResource::collection(Contract::all());
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
