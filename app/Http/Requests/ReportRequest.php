<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'contract_id' => ['required', 'exists:contracts,id'],
            'year' => ['required', 'numeric', 'min:2020'],
            'month' => ['required', 'numeric', 'min:1', 'max:12'],
        ];
    }
}
