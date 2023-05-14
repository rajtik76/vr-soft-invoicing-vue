<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'contract_id' => 'required|exists:contracts,id',
            'name' => ['required', 'string', 'max:255', Rule::unique('tasks')->ignore($this->task?->id)],
            'active' => 'required|boolean',
            'url' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return !Request::isMethod('patch') || Auth::user()->can('update', $this->task);
    }
}
