<?php

namespace App\Api\v1\Drivers;

use App\Api\v1\Exceptions\BotMessageException;
use Telegram\Bot\Objects\Update;

class MessageDriver
{
    private Update $message;

    public function __construct(Update $message)
    {
        $this->message = $message;
    }

    public function getChatId()
    {
        if (isset($this->message['callback_query']['from']['id'])) {
            return $this->message['callback_query']['from']['id'];
        }

        if (isset($this->message['message']['from']['id'])) {
            return $this->message['message']['from']['id'];
        }

        throw new BotMessageException(__('bot_labels.message_from_id_does_not_exist_in_message_array'));
    }

    public function getMessageId()
    {
        if (isset($this->message['callback_query']['message']['message_id'])) {
            return $this->message['callback_query']['message']['message_id'];
        }

        if (isset($this->message['message']['message_id'])) {
            return $this->message['message']['message_id'];
        }

        throw new BotMessageException(
            __('bot_labels.callback_query_message_message_id_does_not_exist_in_message_array')
        );
    }

    public function getIsBot()
    {
        if (isset($this->message['message']['from']['is_bot'])) {
            return $this->message['message']['from']['is_bot'];
        }

        throw new BotMessageException(__('bot_labels.message_from_is_bot_does_not_exist_in_message_array'));
    }

    public function getFirstName()
    {
        if (!empty($this->message['message']['from']['first_name'])) {
            return $this->message['message']['from']['first_name'];
        }

        throw new BotMessageException(__('bot_labels.message_from_first_name_does_not_exist_in_message_array'));
    }

    public function getLastName()
    {
        if (!empty($this->message['message']['from']['last_name'])) {
            return $this->message['message']['from']['last_name'];
        }

        throw new BotMessageException(__('bot_labels.message_from_last_name_does_not_exist_in_message_array'));
    }

    public function getUsername()
    {
        if (!empty($this->message['message']['from']['username'])) {
            return $this->message['message']['from']['username'];
        }

        throw new BotMessageException(__('bot_labels.message_from_username_does_not_exist_in_message_array'));
    }

    public function getLanguageCode()
    {
        if (!empty($this->message['message']['from']['language_code'])) {
            return $this->message['message']['from']['language_code'];
        }

        throw new BotMessageException(
            __('bot_labels.message_from_language_code_does_not_exist_in_message_array')
        );
    }

    public function getChatType()
    {
        if (!empty($this->message['message']['chat']['type'])) {
            return $this->message['message']['chat']['type'];
        }

        throw new BotMessageException(
            __('bot_labels.message_chat_type_does_not_exist_in_message_array')
        );
    }

    public function getText()
    {
        if (isset($this->message['message']['text'])) {
            return $this->message['message']['text'];
        }

        return null;
    }

    public function getCallbackQuery()
    {
        if (isset($this->message['callback_query']['data'])) {
            return $this->message['callback_query']['data'];
        }

        return null;
    }

    public function getCallbackQueryId()
    {
        if (isset($this->message['callback_query']['id'])) {
            return $this->message['callback_query']['id'];
        }

        return null;
    }
}
