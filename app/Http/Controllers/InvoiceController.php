<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Invoice/Index');
    }

    public function create(): Response
    {
        return Inertia::render('Invoice/Create', [
            'contracts' => Contract::all()
                ->mapWithKeys(
                    fn (Contract $contract, $key) => [$contract->id => $contract->customer->name]
                )
                ->toArray()
        ]);
    }

    public function store(InvoiceRequest $request): RedirectResponse
    {
        $contract = Contract::find($request->validated('contract_id'));
        $tasks = Task::with(['spentTimes' => function ($query) use ($request) {
            $query->whereYear('date', $request->validated('year'))
                ->whereMonth('date', $request->validated('month'));
        }])
            ->where('contract_id', $request->validated('contract_id'))
            ->orderBy('name')
            ->get();

        $taskWithSum = [];
        foreach ($tasks as $task) {
            if ($task->spentTimes->sum('time')) {
                // store only task with spent times on it
                $taskWithSum[] = [
                    'name' => $task->name,
                    'url' => $task->url,
                    'hours' => $task->spentTimes->sum('time'),
                ];
            }
        }

        $taskWithSum = collect($taskWithSum);

        $invoice = new Invoice($request->validated());
        $invoice->content = $taskWithSum->toArray();
        $invoice->price_per_unit = $contract->price_per_unit;
        $invoice->total_amount = $taskWithSum->sum('hours') * $invoice->contract->price_per_unit;
        $invoice->currency = $contract->bank->currency;
        $invoice->save();

        return to_route('invoice.index')->with('success', "Invoice {$invoice->number} was successfully created");
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $number = $invoice->number;
        $amount = $invoice->total_amount . ' ' . $invoice->currency->value;

        $invoice->delete();

        return to_route('invoice.index')->with('success', "Invoice {$number} with amount {$amount} was successfully deleted");
    }

    public function show(Invoice $invoice): Response
    {
        return Inertia::render('Invoice/Show', [
            'invoice' => InvoiceResource::make($invoice),
        ]);
    }
}
