<?php

namespace App\Policies;

use App\Models\TaskSpentTime;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskSpentTimePolicy
{
    use HandlesAuthorization;

    public function view(User $user, TaskSpentTime $taskSpentTime): bool
    {
        return $user->id === $taskSpentTime->task->user_id;
    }

    public function update(User $user, TaskSpentTime $taskSpentTime): bool
    {
        return $this->view($user, $taskSpentTime);
    }

    public function delete(User $user, TaskSpentTime $taskSpentTime): bool
    {
        return $this->view($user, $taskSpentTime);
    }
}
