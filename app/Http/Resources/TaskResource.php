<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Task */
class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'note' => $this->note,
            'active' => $this->active,
            'created_at' => $this->created_at->toDateTimeString(),
            'hours' => number_format($this->spent_times_sum_time, 1),
        ];
    }
}
