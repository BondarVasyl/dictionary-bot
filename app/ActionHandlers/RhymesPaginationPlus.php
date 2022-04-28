<?php


namespace App\ActionHandlers;

use App\Api\v1\Drivers\BotDriver;
use App\Api\v1\Drivers\MessageDriver;
use App\Api\v1\Services\WordsAPIService;
use App\Models\RhymesPageInfo;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;

class RhymesPaginationPlus
{
    /**
     * @var BotDriver
     */
    private BotDriver $botDriver;

    public function __construct(BotDriver $botDriver)
    {
        $this->botDriver = $botDriver;
    }

    public function handle(Update $update, $params)
    {
        $message = new MessageDriver($update);

        $callback_id = $message->getCallbackQueryId();

        $telegram_id = $message->getChatId();

        $message_id = $message->getMessageId();

        $info = RhymesPageInfo::query()->where('message_id', $message_id)->first();

        $rhymes = (new WordsAPIService())
            ->getWordRhymes($info->word);
        $result_rhymes = '';

        if ($info->page > 10) {
            $text = array_slice(
                $rhymes['rhymes']['all'],
                $this->botDriver->per_page * (floor($info->page/10) * 10),
                $this->botDriver->per_page * ($info->page - intdiv($info->page, 10) * 10)
            );

            $key = $this->botDriver->per_page * (floor($info->page/10) * 10);

            foreach ($text as $rhyme) {
                $result_rhymes .=
                    ($key + 1) . ') ' . $rhyme . PHP_EOL;

                $key++;

            }
        } else {
            $text = array_slice($rhymes['rhymes']['all'], 0, $this->botDriver->per_page * $info->page);

            foreach ($text as $key => $rhyme) {
                $result_rhymes .=
                    ($key + 1) . ') ' . $rhyme . PHP_EOL;

            }
        }


        $keyboard = null;

        if ($rhymes['rhymes']['all'] > $this->botDriver->per_page * $info->page) {
            $keyboard = Keyboard::make([])->inline();

            foreach (['plus'] as $action) {
                if ($action == 'plus') {
                    $button_text = __('bot_labels.more');
                }

                $keyboard_item = Keyboard::inlineButton(
                    [
                        'text'          => $button_text,
                        'callback_data' => 'rhymes_' . $action
                    ]
                );

                $keyboard = $keyboard->row($keyboard_item);
            }
        }

        $this->botDriver->editMessage($telegram_id, $message_id, $result_rhymes, $keyboard);

        $info->update(['page' => $info->page + 1]);

        $this->botDriver->stopClockAction($callback_id);
    }
}
