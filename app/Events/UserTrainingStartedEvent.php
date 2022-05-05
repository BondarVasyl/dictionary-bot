<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserTrainingStartedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    /**
     * UserTrainingStarted constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
