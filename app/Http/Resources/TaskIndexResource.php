<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Task */
class TaskIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'note' => $this->note,
            'active' => $this->active,
            'hours' => number_format($this->spent_times_sum_time, 1),
            'customer' => CustomerResource::make($this->contract->customer),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
