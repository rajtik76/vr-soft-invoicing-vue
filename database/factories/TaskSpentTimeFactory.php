<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskSpentTimeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'task_id' => Task::factory(),
            'date' => fake()->dateTimeBetween('-3 months'),
            'time' => fake()->randomFloat(1, 1, 10),
            'note' => fake()->sentence(),
        ];
    }
}
