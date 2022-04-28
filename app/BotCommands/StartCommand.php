<?php

namespace App\BotCommands;

use App\Api\v1\Drivers\BotDriver;
use App\Api\v1\Drivers\MessageDriver;
use App\Api\v1\Services\UserService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected string $name = 'start';

    /**
     * @var string Command Description
     */
    protected string $description = 'Start work';
    /**
     * @var BotDriver
     */
    private BotDriver $botDriver;
    /**
     * @var UserService
     */
    private UserService $userService;
    /**
     * @var MessageDriver
     */
    private MessageDriver $message;

    /**username
     * {@inheritdoc}
     */

    public function __construct(UserService $userService, BotDriver $botDriver)
    {
        $this->botDriver = $botDriver;
        $this->userService = $userService;
    }

    public function handle()
    {
        try {
            $this->message = new MessageDriver($this->getUpdate());

            $chat_id = $this->message->getChatId();

            $user = $this->touchUser($chat_id);

            $this->botDriver->showKeyboard(
                $chat_id,
                __('bot_labels.welcome_text', ['user' => $user->profile->getFieldToWelcome()])
            );

        } catch (\Exception $e) {
            Log::info(['start command error' => $e->getMessage()]);
        }
    }

    private function touchUser($chat_id)
    {
        $user = $this->userService->getUserByChatId($chat_id);

        if (!$user) {
            $user = $this->userService->createUser(
                $this->message->getChatId(),
                $this->message->getIsBot()
            );

            $this->userService->createProfile(
                $user,
                $this->message->getFirstName(),
                $this->message->getLastName(),
                $this->message->getUsername(),
                $this->message->getLanguageCode(),
                $this->message->getLanguageCode(),
                'en',
                $this->message->getChatType()
            );

            App::setLocale($user->profile->language_code);
        }

        app()->setLocale($user->profile->language_code);

        return $user;
    }
}
