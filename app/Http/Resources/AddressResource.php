<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Address */
class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'street_name' => $this->street_name,
            'city' => $this->city,
            'zip' => $this->zip,
            'country' => $this->country,
        ];
    }
}
