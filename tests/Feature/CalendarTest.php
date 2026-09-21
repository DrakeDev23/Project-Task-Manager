<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_their_calendar(): void
    {
        $user = User::factory()->create();

        $otherUser = User::factory()->create();

        Task::query()->create([
            'user_id' => $user->id,
            'title' => 'Own task',
            'description' => 'Visible',
            'status' => 'pending',
            'priority' => 'medium',
            'due_date' => now()->addDay()->toDateString(),
        ]);

        Task::query()->create([
            'user_id' => $otherUser->id,
            'title' => 'Other task',
            'description' => 'Hidden',
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => now()->addWeek()->toDateString(),
        ]);

        $response = $this->actingAs($user)->get('/calendar');

        $response->assertOk();
        $response->assertSee('Own task');
        $response->assertDontSee('Other task');
    }
}