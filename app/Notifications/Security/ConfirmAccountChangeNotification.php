<?php

namespace App\Notifications\Security;

use App\Models\AccountChangeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ConfirmAccountChangeNotification extends Notification
{
    use Queueable;

    public function __construct(public AccountChangeRequest $change, public string $token) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = URL::temporarySignedRoute('account-changes.confirm', $this->change->expires_at, [
            'change' => $this->change->id, 'token' => $this->token,
        ]);
        $type = $this->change->type === 'password' ? 'password' : 'username';

        return (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject("Confirm your Hapsay {$type} change")
            ->view(['emails.security.confirm-change', 'emails.security.confirm-change-text'], compact('url', 'type'));
    }
}
