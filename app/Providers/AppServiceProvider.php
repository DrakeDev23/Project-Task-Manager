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
        $this->app->singleton(BaseMailChannel::class, function ($app) {
            $mailFactory = $app->make(\Illuminate\Contracts\Mail\Factory::class);

            $markdownConfig = $app['config']->get('mail.markdown', []);
            $markdown = new \Illuminate\Mail\Markdown($app['view'], $markdownConfig);

            return new ConditionalMailChannel($mailFactory, $markdown);
        });
    }
}
