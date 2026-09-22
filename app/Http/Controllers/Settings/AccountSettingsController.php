<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\AccountChangeRequest;
use App\Models\User;
use App\Notifications\Security\ConfirmAccountChangeNotification;
use App\Notifications\Security\SecurityAlertNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountSettingsController extends Controller
{
    public function edit()
    {
        return view('settings.account');
    }

    public function requestUsernameChange(Request $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validate(['name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($user->id)]]);
        if ($data['name'] === $user->name) {
            return back()->with('status', 'Your username is already up to date.');
        }
        if ($this->hasPendingChange($user, 'username')) {
            return back()->with('status', 'A confirmation email is already pending for this username change.');
        }

        if ($user->email_verified_at) {
            $user->update(['name' => $data['name']]);
            $user->notify(new SecurityAlertNotification('Your Hapsay username was changed', ['When' => now()->toDayDateTimeString().' '.config('app.timezone')]));
            Auth::login($user);
            $request->session()->regenerate();

            return back()->with('status', 'Your username has been changed.');
        }

        $this->createChange($user, 'username', ['name' => $data['name']]);

        return back()->with('status', 'Check your email to confirm the username change.');
    }

    public function requestPasswordChange(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        $user = $request->user();

        if ($this->hasPendingChange($user, 'password')) {
            return back()->with('status', 'A confirmation email is already pending for this password change.');
        }

        if ($user->email_verified_at) {
            $user->update(['password' => Hash::make($data['password']), 'remember_token' => Str::random(60)]);
            DB::table('sessions')->where('user_id', $user->id)->delete();
            $user->notify(new SecurityAlertNotification('Your Hapsay password was changed', ['When' => now()->toDayDateTimeString().' '.config('app.timezone')]));
            Auth::login($user);
            $request->session()->regenerate();

            return back()->with('status', 'Your password has been changed.');
        }

        $this->createChange($user, 'password', ['password_hash' => Hash::make($data['password'])]);

        return back()->with('status', 'Check your email to confirm the password change.');
    }

    public function confirm(Request $request, AccountChangeRequest $change): RedirectResponse
    {
        abort_unless($change->used_at === null && $change->expires_at->isFuture() && Hash::check((string) $request->query('token'), $change->token_hash), 403);
        $user = $change->user;
        if ($change->type === 'username' && User::where('name', $change->payload['name'])->whereKeyNot($user->id)->exists()) {
            return redirect()->route('login')->withErrors(['email' => 'That username is no longer available.']);
        }
        DB::transaction(function () use ($change, $user) {
            $locked = AccountChangeRequest::whereKey($change->id)->lockForUpdate()->firstOrFail();
            abort_unless($locked->used_at === null && $locked->expires_at->isFuture(), 403);
            if ($locked->type === 'username') {
                $user->update(['name' => $locked->payload['name']]);
            }
            if ($locked->type === 'password') {
                $user->update(['password' => $locked->payload['password_hash'], 'remember_token' => Str::random(60)]);
                DB::table('sessions')->where('user_id', $user->id)->delete();
            }
            $locked->update(['used_at' => now()]);
        });
        $event = $change->type === 'password' ? 'Your Hapsay password was changed' : 'Your Hapsay username was changed';
        $user->notify(new SecurityAlertNotification($event, ['When' => now()->toDayDateTimeString().' '.config('app.timezone')]));
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('settings.account')->with('status', 'Your '.$change->type.' has been changed.');
    }

    private function hasPendingChange(User $user, string $type): bool
    {
        return AccountChangeRequest::where('user_id', $user->id)
            ->where('type', $type)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->exists();
    }

    private function createChange(User $user, string $type, array $payload): void
    {
        $token = Str::random(64);
        $change = AccountChangeRequest::create([
            'user_id' => $user->id, 'type' => $type, 'payload' => $payload,
            'token_hash' => Hash::make($token), 'expires_at' => now()->addMinutes(30),
        ]);
        $user->notify(new ConfirmAccountChangeNotification($change, $token));
    }
}
