<?php

namespace App\Notifications\Security;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SecurityAlertNotification extends Notification
{
    use Queueable;

    public function __construct(public string $event, public array $details = []) {}

    public static function newLogin(Request $request): self
    {
        return new self('New login to your Hapsay account', [
            'When' => now()->toDayDateTimeString().' '.config('app.timezone'),
            'Browser / device' => substr((string) $request->userAgent(), 0, 250) ?: 'Unavailable',
            'IP address' => $request->ip() ?: 'Unavailable',
        ]);
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $event = $this->event;
        $details = $this->details;

        return (new MailMessage)->subject($event)->view(['emails.security.alert', 'emails.security.alert-text'], compact('event', 'details'));
    }
}
