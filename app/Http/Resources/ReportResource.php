<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\TaskSpentTime */
class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->date->format('d.m.Y'),
            'time' => $this->time,
            'note' => $this->note,

            'task' => TaskResource::make($this->task),
        ];
    }
}
