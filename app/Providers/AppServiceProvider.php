<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\Channels\MailChannel as BaseMailChannel;
use App\Notifications\Channels\ConditionalMailChannel;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        // Replace the default MailChannel with a ConditionalMailChannel that
        // suppresses external delivery except for the configured prototype address.
        $this->app->singleton(BaseMailChannel::class, function ($app) {
            // Resolve the MailFactory implementation (binds to Illuminate\Mail\MailManager).
            $mailFactory = $app->make(\Illuminate\Contracts\Mail\Factory::class);

            // Construct a Markdown renderer instance if the container binding
            // is not available (ensures this works in minimal dev setups).
            $markdownConfig = $app['config']->get('mail.markdown', []);
            $markdown = new \Illuminate\Mail\Markdown($app['view'], $markdownConfig);

            return new ConditionalMailChannel($mailFactory, $markdown);
        });
    }
}
