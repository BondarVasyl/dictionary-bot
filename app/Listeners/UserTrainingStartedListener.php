<?php

namespace App\Listeners;

use App\Api\v1\Services\TrainingService;
use App\Events\UserTrainingStartedEvent;

class UserTrainingStartedListener
{
    private $trainingService;

    public function __construct(TrainingService $trainingService)
    {
        $this->trainingService = $trainingService;
    }

    public function handle(UserTrainingStartedEvent $event)
    {
        $this->trainingService->startTraining($event->user);
    }
}
