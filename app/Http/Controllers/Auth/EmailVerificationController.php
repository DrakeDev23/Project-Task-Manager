<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\Security\SecurityAlertNotification;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        return request()->user()->hasVerifiedEmail() ? redirect()->route('dashboard') : view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if (! $request->user()->hasVerifiedEmail()) {
            $request->fulfill();
            $request->user()->notify(new SecurityAlertNotification('Your Hapsay email address was verified', ['When' => now()->toDayDateTimeString().' '.config('app.timezone')]));
        }

        return redirect()->route('dashboard')->with('success', 'Your email address has been verified.');
    }

    public function send(Request $request): RedirectResponse
    {
        if (! $request->user()->hasVerifiedEmail()) {
            $request->user()->sendEmailVerificationNotification();
        }

        return back()->with('status', 'If your address is unverified, a new verification email has been sent.');
    }
}
