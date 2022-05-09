<?php

namespace App\Api\v1\Services;

use App\Models\Dictionary;
use App\Models\User;
use App\Models\WordSchedule;
use Carbon\Carbon;

class TrainingService
{
    public function startTraining(User $user)
    {
        $words = Dictionary::query()->where('user_id', $user->id)->inRandomOrder()->get();

        $data = [];

        foreach ($words as $key => $word) {
            $data[] = new WordSchedule([
                'dictionary_id' => $word->id,
                'date'          => Carbon::now()->format('Y-m-d'),
                'time'          => Carbon::now()->addMinutes(($key + 1))->format('H:i'),
                'status'        => false,
                'type'          => WordSchedule::SIMPLE_TYPE
            ]);
        }

        $user->wordSchedules()->saveMany($data);
    }

    public function stopTraining(User $user)
    {
        WordSchedule::where('user_id', $user->id)
            ->where('type', WordSchedule::SIMPLE_TYPE)
            ->update(['status' => true]);
    }

    public function startTranslationTraining(User $user)
    {
        $words = Dictionary::query()->where('user_id', $user->id)->inRandomOrder()->get();

        $data = [];

        foreach ($words as $key => $word) {
            $data[] = new WordSchedule([
                'dictionary_id' => $word->id,
                'date'          => Carbon::now()->format('Y-m-d'),
                'time'          => Carbon::now()->addMinutes(($key + 1))->format('H:i'),
                'status'        => false,
                'type'          => WordSchedule::WORD_WITH_TRANSLATION_TYPE
            ]);
        }

        $user->wordSchedules()->saveMany($data);
    }

    public function stopTranslationTraining(User $user)
    {
        WordSchedule::where('user_id', $user->id)
            ->where('type', WordSchedule::WORD_WITH_TRANSLATION_TYPE)
            ->update(['status' => true]);
    }
}
