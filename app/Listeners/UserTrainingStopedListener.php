<?php

namespace App\Listeners;

use App\Api\v1\Services\TrainingService;
use App\Events\UserTrainingStopedEvent;

class UserTrainingStopedListener
{
    private $trainingService;

    public function __construct(TrainingService $trainingService)
    {
        $this->trainingService = $trainingService;
    }

    public function handle(UserTrainingStopedEvent $event)
    {
        $this->trainingService->stopTraining($event->user);
    }
}
