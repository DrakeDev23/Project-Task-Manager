<?php

namespace Tests\Feature;

use App\Models\AccountChangeRequest;
use App\Models\Task;
use App\Models\User;
use App\Notifications\Auth\ResetPasswordNotification;
use App\Notifications\Auth\VerifyEmailNotification;
use App\Notifications\Security\SecurityAlertNotification;
use App\Notifications\Tasks\TaskNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_sends_a_verification_notification(): void
    {
        Notification::fake();
        $this->post(route('register.store'), ['name' => 'A Unique User', 'email' => 'new@gmail.com', 'password' => 'password123', 'password_confirmation' => 'password123'])
            ->assertRedirect(route('dashboard'));
        Notification::assertSentTo(User::whereEmail('new@gmail.com')->first(), VerifyEmailNotification::class);
    }

    public function test_signed_email_verification_marks_the_address_verified(): void
    {
        Notification::fake();
        $user = User::factory()->unverified()->create();
        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(10), ['id' => $user->id, 'hash' => sha1($user->email)]);
        $this->actingAs($user)->get($url)->assertRedirect(route('dashboard'));
        $this->assertNotNull($user->fresh()->email_verified_at);
        Notification::assertSentTo($user, SecurityAlertNotification::class);
    }

    public function test_password_reset_response_does_not_enumerate_users(): void
    {
        Notification::fake();
        $user = User::factory()->create(['email' => 'known@example.com']);
        $this->post(route('password.email'), ['email' => 'known@example.com'])->assertSessionHas('status');
        $this->post(route('password.email'), ['email' => 'unknown@example.com'])->assertSessionHas('status');
        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function test_only_gmail_addresses_can_register(): void
    {
        $this->post(route('register.store'), ['name' => 'Gmail User', 'email' => 'user@gmail.com', 'password' => 'password123', 'password_confirmation' => 'password123'])
            ->assertRedirect(route('dashboard'));

        auth()->logout();

        $this->from(route('register'))->post(route('register.store'), ['name' => 'Other User', 'email' => 'user@example.com', 'password' => 'password123', 'password_confirmation' => 'password123'])
            ->assertSessionHasErrors(['email' => 'Only Gmail addresses are allowed.']);
    }

    public function test_password_change_only_applies_after_a_valid_single_use_confirmation(): void
    {
        Notification::fake();
        $user = User::factory()->create(['name' => 'Password User', 'password' => Hash::make('old-password')]);
        $change = AccountChangeRequest::create(['user_id' => $user->id, 'type' => 'password', 'payload' => ['password_hash' => Hash::make('new-password')], 'token_hash' => Hash::make('opaque-token'), 'expires_at' => now()->addMinutes(30)]);
        $url = URL::temporarySignedRoute('account-changes.confirm', now()->addMinutes(30), ['change' => $change->id, 'token' => 'opaque-token']);
        $this->get($url)->assertRedirect(route('settings.account'));
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
        $this->get($url)->assertForbidden();
    }

    public function test_pending_account_change_request_does_not_create_a_second_confirmation_email(): void
    {
        Notification::fake();
        $user = User::factory()->create(['name' => 'Original Name']);
        AccountChangeRequest::create([
            'user_id' => $user->id,
            'type' => 'username',
            'payload' => ['name' => 'Requested Name'],
            'token_hash' => Hash::make('existing-token'),
            'expires_at' => now()->addMinutes(30),
        ]);

        $this->actingAs($user)
            ->post(route('settings.username.request'), ['name' => 'Another Name'])
            ->assertSessionHas('status', 'A confirmation email is already pending for this username change.');

        Notification::assertNothingSent();
    }

    public function test_completed_task_sends_its_owner_a_reusable_task_notification(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create(['status' => 'pending']);
        $this->actingAs($user)->put(route('tasks.update', $task), ['title' => $task->title, 'description' => $task->description, 'category_id' => null, 'priority' => $task->priority, 'due_date' => $task->due_date?->toDateString(), 'status' => 'completed'])->assertRedirect(route('tasks.index'));
        Notification::assertSentTo($user, TaskNotification::class);
    }
}
