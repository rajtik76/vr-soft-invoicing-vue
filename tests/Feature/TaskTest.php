<?php

namespace Tests\Feature;

use App\Models\Contract;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function test_task_index_page_not_displayed_without_authorized_user()
    {
        $response = $this->get('/task');

        $response->assertRedirect('/login');
    }

    public function test_task_edit_page_not_displayed_without_authorized_user()
    {
        $response = $this->get('/task/1/edit');

        $response->assertRedirect('/login');
    }

    public function test_task_create_page_not_displayed_without_authorized_user()
    {
        $response = $this->get('/task/create');

        $response->assertRedirect('/login');
    }

    public function test_task_index_page_displayed()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/task');

        $response->assertOk();
    }

    public function test_task_edit_page_displayed()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get('/task/' . $task->id . '/edit');

        $response->assertOk();
    }

    public function test_task_create_page_displayed()
    {
        $response = $this->actingAs($this->user)->get('/task/create');

        $response->assertOk();
    }

    public function test_display_edit_of_different_user_task_failed()
    {
        $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

        $response = $this->actingAs($this->user)->get('/task/' . $task->id . '/edit');

        $response->assertForbidden();
    }

    public function test_task_filter_toggle_works()
    {
        $response = $this->actingAs($this->user)->post('/task/toggle-active');

        $response->assertRedirect('/task');
        $this->assertFalse(Session::get('task.active'));

        $this->actingAs($this->user)->post('/task/toggle-active');

        $response->assertRedirect('/task');
        $this->assertTrue(Session::get('task.active'));
    }

    public function test_task_created_successfully()
    {
        $contract = Contract::factory()->create();

        $response = $this->actingAs($this->user)->post(
            uri: '/task',
            data: [
                'contract_id' => $contract->id,
                'name' => 'Test task',
                'note' => 'Test note',
                'url' => 'Test URL',
                'active' => true
            ]
        );

        $response->assertRedirect('/task');
        $this->assertDatabaseHas('tasks', [
            'user_id' => $this->user->id,
            'name' => 'Test task',
            'contract_id' => $contract->id,
            'url' => 'Test URL',
            'note' => 'Test note',
            'active' => true,
        ]);
    }

    public function test_task_edited_successfully()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);
        $contract = Contract::factory()->create();

        $response = $this->actingAs($this->user)->patch(
            uri: '/task/' . $task->id,
            data: [
                'contract_id' => $contract->id,
                'name' => 'Test task',
                'note' => 'Test note',
                'url' => 'Test URL',
                'active' => true
            ]
        );

        $response->assertRedirect('/task');
        $this->assertDatabaseHas('tasks', [
            'user_id' => $this->user->id,
            'name' => 'Test task',
            'contract_id' => $contract->id,
            'url' => 'Test URL',
            'note' => 'Test note',
            'active' => true,
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
}
