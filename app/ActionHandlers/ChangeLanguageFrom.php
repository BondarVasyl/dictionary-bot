<?php

namespace App\ActionHandlers;

use App\Api\v1\Drivers\BotDriver;
use App\Api\v1\Drivers\MessageDriver;
use App\Models\Profile;
use Telegram\Bot\Objects\Update;

class ChangeLanguageFrom
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

        $this->botDriver->stopClockAction($callback_id);

        Profile::with(['user' => function ($q) use ($telegram_id) {
            $q->where('telegram_id', $telegram_id);
        }])
            ->update(['language_from' => $params['locale']]);

        $this->botDriver->sendMessage($telegram_id, __('bot_labels.language_is_successfully_changed'));

        $this->botDriver->deleteMessage($telegram_id, $message->getMessageId());

        $this->botDriver->showKeyboard($telegram_id);
    }
}
