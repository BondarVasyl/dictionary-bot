<?php

namespace App\Providers;

use App\Events\UserTrainingStartedEvent;
use App\Events\UserTrainingStopedEvent;
use App\Listeners\UserTrainingStartedListener;
use App\Listeners\UserTrainingStopedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserTrainingStartedEvent::class => [
            UserTrainingStartedListener::class
        ],
        UserTrainingStopedEvent::class => [
            UserTrainingStopedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
