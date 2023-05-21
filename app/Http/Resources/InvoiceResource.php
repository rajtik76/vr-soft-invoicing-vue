<?php

namespace App\Http\Resources;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Invoice */
class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'year' => $this->year,
            'month' => $this->month,
            'issue_date' => $this->issue_date->format('d.m.Y'),
            'due_date' => $this->due_date->format('d.m.Y'),
            'content' => $this->content,
            'price_per_unit' => $this->price_per_unit,
            'total_amount' => $this->total_amount,
            'currency' => $this->currency,
            'currency_symbol' => $this->currency->symbol(),
            'created_at' => $this->created_at?->toDateTimeString(),

            'contract' => ContractResource::make($this->contract),
        ];
    }
}
