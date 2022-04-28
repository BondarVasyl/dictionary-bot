<?php

namespace App\Api\v1\Drivers;

use App\Api\v1\Services\TranslationService;
use App\Api\v1\Services\WordsAPIService;
use App\Models\Profile;
use App\Models\RhymesPageInfo;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Objects\Update;

class BotDriver
{
    public $per_page = 25;

    public function analyzeText(Update $update)
    {
        $message = new MessageDriver($update);
        $chat_id = $message->getChatId();

        $user = User::with('profile')->ofChatId($chat_id)->first();

        switch ($message->getText()) {
            case __('bot_labels.change_bot_language')
                . '(' . country_flag(detect_locale(app()->getLocale()))
                . ')':
                $this->sendLanguageKeyboard($chat_id);
                break;
            case __('bot_labels.translate_from_language')
                . country_flag(detect_locale($user->profile->language_from))
                . '(' . __('bot_labels.change') . ')':
                $this->sendChangeTranslateFromKeyboard($chat_id);
                break;
            case __('bot_labels.translate_to_language')
                . country_flag(detect_locale($user->profile->language_to))
                . '(' . __('bot_labels.change') . ')':
                $this->sendChangeTranslateToKeyboard($chat_id);
                break;
            case __('bot_labels.analyze_word'):
                $user->profile()->update(['analyze_session_started' => true]);
                $this->sendMessage($chat_id, __('bot_labels.write_the_word'));
                break;
            case __('bot_labels.close_analyze_keyboard'):
                $user->profile()->update(['last_requested_word' => null]);
                RhymesPageInfo::where('chat_id', $user->telegram_id)->delete();

                $this->showKeyboard($chat_id);
                break;
            case __('bot_labels.definitions'):
                try {
                    $definition = (new WordsAPIService())
                        ->getWordDefinition($user->profile->last_requested_word);
                    $this->sendMessage($chat_id, $definition);
                } catch (\Exception $e) {
                    if ($e->getCode() == '404') {
                        $this->sendMessage($chat_id, __('bot_labels.definition_not_found'));
                    } else {
                        $this->sendMessage(
                            $chat_id,
                            __('bot_labels.an_error_occurred_while_searching_for_a_definition')
                        );
                    }
                }
                break;
            case __('bot_labels.synonyms'):
                try {
                    $synonyms = (new WordsAPIService())
                        ->getWordSynonyms($user->profile->last_requested_word);

                    $this->sendMessage($chat_id, $synonyms);
                } catch (\Exception $e) {
                    if ($e->getCode() == '404') {
                        $this->sendMessage($chat_id, __('bot_labels.synonym_not_found'));
                    } else {
                        $this->sendMessage(
                            $chat_id,
                            __('bot_labels.an_error_occurred_while_searching_for_a_synonyms')
                        );
                    }
                }
                break;
            case __('bot_labels.antonyms'):
                try {
                    $antonyms = (new WordsAPIService())
                        ->getWordAntonyms($user->profile->last_requested_word);

                    $this->sendMessage($chat_id, $antonyms);
                } catch (\Exception $e) {
                    if ($e->getCode() == '404') {
                        $this->sendMessage($chat_id, __('bot_labels.antonyms_not_found'));
                    } else {
                        $this->sendMessage(
                            $chat_id,
                            __('bot_labels.an_error_occurred_while_searching_for_a_antonyms')
                        );
                    }
                }
                break;
            case __('bot_labels.rhymes'):
                try {
                    $rhymes = (new WordsAPIService())
                        ->getWordRhymes($user->profile->last_requested_word);

                    $this->sendRhymes($chat_id, $rhymes, $message->getMessageId(), $user);
                } catch (\Exception $e) {
                    if ($e->getCode() == '404') {
                        $this->sendMessage($chat_id, __('bot_labels.rhymes_not_found'));
                    } else {
                        $this->sendMessage(
                            $chat_id,
                            __('bot_labels.an_error_occurred_while_searching_for_a_rhymes')
                        );
                    }

                    Log::info(['error' => $e->getMessage()]);
                }
                break;
            case __('bot_labels.pronunciation'):
                try {
                    $pronunciation = (new WordsAPIService())
                        ->getWordPronunciation($user->profile->last_requested_word);

                    $this->sendMessage($chat_id, $pronunciation);
                } catch (\Exception $e) {
                    if ($e->getCode() == '404') {
                        $this->sendMessage($chat_id, __('bot_labels.pronunciation_not_found'));
                    } else {
                        $this->sendMessage(
                            $chat_id,
                            __('bot_labels.an_error_occurred_while_searching_for_a_pronunciation')
                        );
                    }
                }
                break;
            case __('bot_labels.syllables') :
                try {
                    $syllables = (new WordsAPIService())
                        ->getWordSyllables($user->profile->last_requested_word);

                    $this->sendMessage($chat_id, $syllables);
                } catch (\Exception $e) {
                    if ($e->getCode() == '404') {
                        $this->sendMessage($chat_id, __('bot_labels.syllables_not_found'));
                    } else {
                        $this->sendMessage(
                            $chat_id,
                            __('bot_labels.an_error_occurred_while_searching_for_syllables')
                        );
                    }
                }
                break;
            case __('bot_labels.frequency'):
                try {
                    $frequency = (new WordsAPIService())
                        ->getWordFrequency($user->profile->last_requested_word);

                    $this->sendMessage($chat_id, $frequency);
                } catch (\Exception $e) {
                    if ($e->getCode() == '404') {
                        $this->sendMessage($chat_id, __('bot_labels.frequency_not_found'));
                    } else {
                        $this->sendMessage(
                            $chat_id,
                            __('bot_labels.an_error_occurred_while_searching_for_frequency')
                        );
                    }
                }
                break;
            default:
                if ($user->profile->analyze_session_started) {
                    $response = (new TranslationService())
                        ->getWordTranslation(
                            $message->getText(),
                            $user->profile->language_from,
                            $user->profile->language_to
                        );

                    $text = $response['original_text']
                        . ' => ' . $response['translated_text'][$user->profile->language_to];

                    $this->sendMessage($chat_id, $text);

                    $user->profile()->update([
                        'last_requested_word' => $message->getText(),
                        'analyze_session_started' => false
                    ]);

                    $this->showAnalyzeKeyboard($chat_id);
                }

                break;
        }
    }

    public function assignAction(Update $update)
    {
        $message = new MessageDriver($update);

        $action = $message->getCallbackQuery();

        if ($action) {
            $data = $this->detectActionClassWithParams($action);

            if (!empty($data) && isset($data['class']) && class_exists($data['class'])) {
                $handler = app()->make($data['class']);

                $handler->handle($update, $data['params']);
            }
        }
    }

    public function sendMessage($chat_id, $text)
    {
        try {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => $text,
            ]);
        } catch (TelegramResponseException $e) {
            $errorData = $e->getResponseData();

            if ($errorData['ok'] === false) {
                Log::info(['send_message_error' => $errorData]);
            }
        }
    }

    public function deleteMessage($chat_id, $message_id)
    {
        try {
            Telegram::deleteMessage([
                'chat_id' => $chat_id,
                'message_id' => $message_id,
            ]);
        } catch (TelegramResponseException $e) {
            $errorData = $e->getResponseData();

            if ($errorData['ok'] === false) {
                Log::info(['delete_message_error' => $errorData]);
            }
        }
    }

    public function editMessage($chat_id, $message_id, $text, $reply_markup = null)
    {
        try {
            $data = [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => $text
            ];

            if ($reply_markup) {
                $data['reply_markup'] = $reply_markup;
            }

            Telegram::editMessageText($data);

        } catch (TelegramResponseException $e) {
            $errorData = $e->getResponseData();

            if ($errorData['ok'] === false) {
                Log::info(['edit_message_error' => $errorData]);
            }
        }
    }

    public function showKeyboard($chat_id, $text = null)
    {
        $user = User::with('profile')->ofChatId($chat_id)->first();

        $keyboard = [
            [__('bot_labels.analyze_word')],
            [__('bot_labels.change_bot_language') . '(' . country_flag(detect_locale(app()->getLocale())) . ')'],
            [
                __('bot_labels.translate_from_language')
                . country_flag(detect_locale($user->profile->language_from)) . '(' . __('bot_labels.change') . ')',
                __('bot_labels.translate_to_language')
                . country_flag(detect_locale($user->profile->language_to)) . '(' . __('bot_labels.change') . ')'
            ]
        ];

        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);

        if (!$text) {
            $text = __('bot_labels.menu');
        }

        $this->sendKeyBoard($chat_id, $text, $reply_markup);
    }

    public function showAnalyzeKeyboard($chat_id, $text = null)
    {
        $keyboard = [
            [__('bot_labels.definitions'), __('bot_labels.synonyms')],
            [__('bot_labels.antonyms'), __('bot_labels.rhymes')],
            [__('bot_labels.pronunciation'), __('bot_labels.syllables')],
            [__('bot_labels.frequency'), __('bot_labels.close_analyze_keyboard')]
        ];

        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);

        if (!$text) {
            $text = __('bot_labels.use_analyze_key_board_to_more_information');
        }

        $this->sendKeyBoard(
            $chat_id,
            $text,
            $reply_markup
        );
    }

    public function sendKeyBoard($chat_id, $text, $keyboard)
    {
        try {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => $text,
                'reply_markup' => $keyboard
            ]);
        } catch (TelegramResponseException $e) {
            $errorData = $e->getResponseData();

            if ($errorData['ok'] === false) {
                Log::info(['send_key_board_error' => $errorData]);
            }
        }
    }

    public function sendLanguageKeyboard($chat_id)
    {
        $locale = app()->getLocale();
        $locales = config('app.locales');

        $keyboard = Keyboard::make([])->inline();
        $text = __('bot_labels.select_language');

        foreach ($locales as $item) {
            $button_text = country_flag(detect_locale($item)) . ' ' . ucfirst($item);

            if ($item == $locale) {
                $button_text .= ' (' . __('bot_labels.current') . ')';
            }

            $keyboard_item = Keyboard::inlineButton(
                [
                    'text' => $button_text,
                    'callback_data' => 'set_language_' . $item
                ]
            );

            $keyboard = $keyboard->row($keyboard_item);
        }

        $this->sendKeyBoard($chat_id, $text, $keyboard);
    }

    public function sendChangeTranslateFromKeyboard($chat_id)
    {
        $user = User::with('profile')->ofChatId($chat_id)->first();

        $locales = config('app.locales');

        $keyboard = Keyboard::make([])->inline();

        $text = __('bot_labels.select_language');

        foreach ($locales as $locale) {
            $button_text = country_flag(detect_locale($locale)) . ' ' . ucfirst($locale);

            if ($locale == $user->profile->language_from) {
                $button_text .= ' (' . __('bot_labels.current') . ')';
            }

            $keyboard_item = Keyboard::inlineButton(
                [
                    'text' => $button_text,
                    'callback_data' => 'change_language_from_' . $locale
                ]
            );

            $keyboard = $keyboard->row($keyboard_item);
        }

        $this->sendKeyBoard($chat_id, $text, $keyboard);
    }

    public function sendChangeTranslateToKeyboard($chat_id)
    {
        $user = User::with('profile')->ofChatId($chat_id)->first();

        $locales = config('app.locales');

        $keyboard = Keyboard::make([])->inline();

        $text = __('bot_labels.select_language');

        foreach ($locales as $locale) {
            $button_text = country_flag(detect_locale($locale)) . ' ' . ucfirst($locale);

            if ($locale == $user->profile->language_from) {
                $button_text .= ' (' . __('bot_labels.current') . ')';
            }

            $keyboard_item = Keyboard::inlineButton(
                [
                    'text' => $button_text,
                    'callback_data' => 'change_language_to_' . $locale
                ]
            );

            $keyboard = $keyboard->row($keyboard_item);
        }

        $this->sendKeyBoard($chat_id, $text, $keyboard);
    }

    public function stopClockAction($callback_id)
    {
        Telegram::answerCallbackQuery([
            'callback_query_id' => $callback_id
        ]);
    }

    public function detectActionClassWithParams($action): array
    {
        $data = [];

        if (str_contains($action, 'set_language')) {
            $data['class'] = '\App\ActionHandlers\SetLanguage';

            $data['params']['locale'] = substr($action, strrpos($action, '_') + 1);

        }

        if (str_contains($action, 'change_language_from')) {
            $data['class'] = '\App\ActionHandlers\ChangeLanguageFrom';

            $data['params']['locale'] = substr($action, strrpos($action, '_') + 1);
        }

        if (str_contains($action, 'change_language_to')) {
            $data['class'] = '\App\ActionHandlers\ChangeLanguageTo';

            $data['params']['locale'] = substr($action, strrpos($action, '_') + 1);
        }

        if (str_contains($action, 'rhymes')) {
            if (str_contains($action, 'plus')) {
                $data['class'] = '\App\ActionHandlers\RhymesPaginationPlus';
                $data['params'] = [];
            }

            if (str_contains($action, 'minus')) {
                $data['class'] = '\App\ActionHandlers\RhymesPaginationMinus';
                $data['params'] = [];
            }
        }

        return $data;
    }

    public function setLanguage($locale = null, Update $update = null)
    {
        if ($locale) {
            app()->setLocale($locale);

            return true;
        }

        $message = new MessageDriver($update);

        $chat_id = $message->getChatId();

        $profile = Profile::with(['user' => function ($q) use ($chat_id) {
            $q->where('telegram_id', $chat_id);
        }])
            ->select('language_code')
            ->first();

        if ($profile) {
            app()->setLocale($profile->language_code);
        }
    }

    public function sendRhymes($chat_id, $rhymes, $message_id, $user)
    {
        $page_count = ceil(count($rhymes['rhymes']['all']) / $this->per_page);

        if ($page_count >= 2) {
            $text = $this->firstPaginatedText($rhymes);
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

            $this->sendKeyBoard($chat_id, $text, $keyboard);

            RhymesPageInfo::create([
                'chat_id'    => $user->telegram_id,
                'message_id' => $message_id + 1,
                'page'       => 2,
                'word'       => $rhymes['word']
            ]);
        } else {
            $result_rhymes = '';
            foreach ($rhymes['rhymes']['all'] as $key => $rhyme) {
                $result_rhymes .=
                    ($key + 1) . ') ' . $rhyme . PHP_EOL;
            }

            $this->sendMessage($chat_id, $result_rhymes);
        }
    }

    private function firstPaginatedText($rhymes): string
    {
        $first = array_slice($rhymes['rhymes']['all'], 0, $this->per_page);

        $result_rhymes = '';

        foreach ($first as $key => $rhyme) {
            $result_rhymes .=
                ($key + 1) . ') ' . $rhyme . PHP_EOL;
        }

        return $result_rhymes;
    }
}
