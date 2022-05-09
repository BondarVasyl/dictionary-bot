<?php

namespace App\Console\Commands;

use App\Api\v1\Drivers\BotDriver;
use App\Models\WordSchedule;
use Carbon\Carbon;

class SendUserTranslationWordCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user_translation_words:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send to user words for translation training from schedule';

    private $botDriver;

    public function __construct(BotDriver $botDriver)
    {
        parent::__construct();
        $this->botDriver = $botDriver;
    }

    public function handle()
    {
        $this->start();

        $words_schedule = WordSchedule::with('dictionary')
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->where('time', Carbon::now()->format('H:i'))
            ->where('status', false)
            ->where('type', WordSchedule::WORD_WITH_TRANSLATION_TYPE)
            ->get();

        foreach ($words_schedule as $word) {
            $text = ('bot_labels.send_translation_of_this_word') . ' ' . $word->dictionary->word;
            $exist_next_word = WordSchedule::where('user_id', $word->user_id)
                ->where('type', WordSchedule::WORD_WITH_TRANSLATION_TYPE)
                ->where('status', false)->where('id', '!=', $word->id)->exists();

            if (!$exist_next_word) {
                $text .= PHP_EOL . __('bot_labels.it_was_the_last_one_good_job');
            }

            $this->botDriver->sendMessage($word->user->telegram_id, $text);
        }

        WordSchedule::whereIn('id', $words_schedule->pluck('id')->toArray())->update(['status' => true]);

        $this->end();
    }
}
