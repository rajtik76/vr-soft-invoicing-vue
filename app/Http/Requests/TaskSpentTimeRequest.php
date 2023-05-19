<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TaskSpentTimeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'task_id' => ['required', 'exists:tasks,id'],
            'date' => ['required', 'date'],
            'time' => ['required', 'numeric', 'min:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return !$this->time->id || Auth::user()->can('update', $this->time);
    }
}
