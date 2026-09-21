<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_and_view_their_categories(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/categories', [
                'name' => 'Work',
                'description' => 'Client and project tasks',
            ])
            ->assertRedirect('/categories');

        $this->assertDatabaseHas('categories', [
            'user_id' => $user->id,
            'name' => 'Work',
            'description' => 'Client and project tasks',
        ]);

        $this->get('/categories')
            ->assertOk()
            ->assertSee('Categories')
            ->assertSee('Work')
            ->assertSee('Client and project tasks');
    }

    public function test_user_can_only_manage_their_own_categories(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $category = Category::factory()->for($otherUser)->create();

        $this->actingAs($owner)
            ->get('/categories/' . $category->id . '/edit')
            ->assertForbidden();

        $this->actingAs($owner)
            ->put('/categories/' . $category->id, [
                'name' => 'Hacked name',
            ])
            ->assertForbidden();
    }

    public function test_category_tracks_assigned_tasks_count(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->for($user)->create();

        Task::factory()->for($user)->for($category)->create();
        Task::factory()->for($user)->create();

        $this->actingAs($user)
            ->get('/categories')
            ->assertOk()
            ->assertSee('1 task');
    }
}
