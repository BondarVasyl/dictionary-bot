<?php

namespace App\Listeners;

use App\Api\v1\Services\TrainingService;
use App\Events\UserTranslationTrainingStopedEvent;

class UserTranslationTrainingStopedListener
{
    private $trainingService;

    public function __construct(TrainingService $trainingService)
    {
        $this->trainingService = $trainingService;
    }

    public function handle(UserTranslationTrainingStopedEvent $event)
    {
        $this->trainingService->stopTranslationTraining($event->user);
    }
}
