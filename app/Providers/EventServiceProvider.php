<?php

namespace App\Providers;

use App\Events\UserTrainingStartedEvent;
use App\Events\UserTrainingStopedEvent;
use App\Events\UserTranslationTrainingStartedEvent;
use App\Events\UserTranslationTrainingStopedEvent;
use App\Listeners\UserTrainingStartedListener;
use App\Listeners\UserTrainingStopedListener;
use App\Listeners\UserTranslationTrainingStartedListener;
use App\Listeners\UserTranslationTrainingStopedListener;
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
        ],
        UserTranslationTrainingStartedEvent::class => [
            UserTranslationTrainingStartedListener::class
        ],
        UserTranslationTrainingStopedEvent::class => [
            UserTranslationTrainingStopedListener::class
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
