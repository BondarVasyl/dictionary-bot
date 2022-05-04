<?php

namespace App\Http\Listeners;

use App\Http\Events\UserTrainingStartedEvent;

class UserTrainingStartedListener
{
    public function handle(UserTrainingStartedEvent $event)
    {
        //todo : generate word list for cron sending
    }
}
