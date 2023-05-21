<?php

namespace App\Http\Controllers\Grid;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\GridComponentHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function __invoke(GridComponentHandler $handler): JsonResponse
    {
        return response()->json(
            $handler
                ->setResource(InvoiceResource::class)
                ->setBuilder(Invoice::query()->with('contract'))
                ->setSortClosure('date',
                    fn(Builder $builder, string $order) => $builder->orderByRaw('CONCAT(year, month) ' . Str::upper($order))
                )
        );
    }
}
