<?php

namespace App\Listeners;

use App\Api\v1\Services\TrainingService;
use App\Events\UserTranslationTrainingStartedEvent;

class UserTranslationTrainingStartedListener
{
    private $trainingService;

    public function __construct(TrainingService $trainingService)
    {
        $this->trainingService = $trainingService;
    }

    public function handle(UserTranslationTrainingStartedEvent $event)
    {
        $this->trainingService->startTranslationTraining($event->user);
    }
}
