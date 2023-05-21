<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\CompanyDetail */
class CompanyDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vat_number' => $this->vat_number,
            'registration_number' => $this->registration_number,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
    }
}
