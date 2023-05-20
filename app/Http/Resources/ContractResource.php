<?php

namespace App\Http\Resources;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Contract */
class ContractResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'signed_at' => $this->signed_at,
            'price_per_unit' => $this->price_per_unit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'customer' => CustomerResource::make($this->customer),
        ];
    }
}
