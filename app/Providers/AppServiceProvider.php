<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       // لضمان عمل الروابط بشكل صحيح على Vercel
    $this->app->bind('path.public', function() {
        return base_path('public');
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Welcome to Lingobase - Verify Your Email')
                ->greeting('Welcome to Lingobase')
                ->line('Hi ' . $notifiable->name . ',')
                ->line('Please verify your email address by clicking the link below:')
                ->action('Verify Email Address', $url);
        });
    }
}
