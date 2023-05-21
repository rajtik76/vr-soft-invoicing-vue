<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\TaskSpentTime */
class TaskSpentTimeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'task' => TaskResource::make($this->task),
            'date' => $this->date?->toDateString(),
            'time' => $this->time,
            'note' => $this->note,
        ];
    }
}
