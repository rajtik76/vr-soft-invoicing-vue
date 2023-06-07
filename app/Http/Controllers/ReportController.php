<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Http\Resources\ContractResource;
use App\Http\Resources\ReportResource;
use App\Models\Contract;
use App\Models\TaskSpentTime;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Report/Create', [
            'contracts' => Contract::all()
                ->mapWithKeys(fn (Contract $contract, $key) => [$contract->id => $contract->customer->name])
                ->toArray()
        ]);
    }

    public function show(ReportRequest $request): Response
    {
        $validated = $request->validated();

        return Inertia::render('Report/Show', [
            'reportDate' => $validated['year'] . '/' . $validated['month'],
            'contract' => ContractResource::make(Contract::findOrFail($validated['contract_id'])),
            'taskSpentTimes' => ReportResource::collection(
                TaskSpentTime::with('task')
                    ->whereYear('date', $validated['year'])
                    ->whereMonth('date', $validated['month'])
                    ->whereHas(
                        'task',
                        fn (Builder $query) => $query->where('contract_id', $validated['contract_id'])
                    )
                    ->orderBy('date')
                    ->orderBy('task_id')
                    ->get()
            )
        ]);
    }
}
