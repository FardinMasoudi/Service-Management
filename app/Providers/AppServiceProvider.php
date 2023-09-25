<?php

namespace App\Providers;

use App\Notifications\TicketSmsNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Notification::class,function (){
            return new TicketSmsNotification();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
