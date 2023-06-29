<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskSpentTime;
use Illuminate\Database\Seeder;

class TaskSpentTimeSeeder extends Seeder
{
    public function run()
    {
        foreach (Task::all() as $task) {
            TaskSpentTime::factory(fake()->numberBetween(1, 5))->create([
                'user_id' => $task->user_id,
                'task_id' => $task->id
            ]);
        }
    }
}
