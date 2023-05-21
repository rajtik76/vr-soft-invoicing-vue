<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'contract_id' => ['required', 'exists:contracts,id'],
            'number' => ['required', 'integer', 'unique:invoices,number'],
            'year' => ['required', 'integer'],
            'month' => ['required', 'integer'],
            'issue_date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
        ];
    }
}
