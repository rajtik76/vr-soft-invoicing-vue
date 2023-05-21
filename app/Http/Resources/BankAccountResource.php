<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\BankAccount */
class BankAccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'bank_name' => $this->bank_name,
            'bank_code' => $this->bank_code,
            'number' => $this->number,
            'iban' => $this->iban,
            'swift' => $this->swift,
            'currency' => $this->currency,
        ];
    }
}
