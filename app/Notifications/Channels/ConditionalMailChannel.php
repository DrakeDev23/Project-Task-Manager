<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Channels\MailChannel as BaseMailChannel;
use Illuminate\Mail\Markdown;
use Illuminate\Contracts\Mail\Factory as MailFactory;
use Illuminate\Support\Facades\Log;

/**
 * ConditionalMailChannel wraps the default MailChannel and suppresses
 * external delivery when prototype mode is enabled and the recipient is
 * not the configured prototype address.
 */
class ConditionalMailChannel extends BaseMailChannel
{
    protected $mailer;
    protected $markdown;

    public function __construct(\Illuminate\Contracts\Mail\Factory $mailer, Markdown $markdown)
    {
        parent::__construct($mailer, $markdown);
        $this->mailer = $mailer;
        $this->markdown = $markdown;
    }

    public function send($notifiable, Notification $notification)
    {
        $mailMessage = $notification->toMail($notifiable);

        // Resolve recipients using the same logic as BaseMailChannel
        if (is_string($recipients = $notifiable->routeNotificationFor('mail', $notification))) {
            $recipients = [$recipients];
        }

        $resolved = (new \Illuminate\Support\Collection($recipients))
            ->mapWithKeys(function ($recipient, $email) {
                return is_numeric($email)
                    ? [$email => (is_string($recipient) ? $recipient : $recipient->email)]
                    : [$email => $recipient];
            })
            ->all();

        $enabled = filter_var(config('prototype.enabled'), FILTER_VALIDATE_BOOLEAN);
        $allowed = strtolower((string) config('prototype.email'));

        if ($enabled && $allowed !== '') {
            foreach ($resolved as $r) {
                if (strtolower($r) !== $allowed) {
                    Log::info('Prototype mail suppressed for: '.implode(', ', $resolved), ['allowed' => $allowed]);
                    return null;
                }
            }
        }

        return parent::send($notifiable, $notification);
    }

    // Expose protected method from BaseMailChannel via same logic here.
    protected function getRecipients($notifiable, $notification, $message)
    {
        if (is_string($recipients = $notifiable->routeNotificationFor('mail', $notification))) {
            $recipients = [$recipients];
        }

        return (new \Illuminate\Support\Collection($recipients))
            ->mapWithKeys(function ($recipient, $email) {
                return is_numeric($email)
                    ? [$email => (is_string($recipient) ? $recipient : $recipient->email)]
                    : [$email => $recipient];
            })
            ->all();
    }
}
