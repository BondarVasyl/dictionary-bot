<?php


namespace App\Api\v1\Services;

use App\Models\User;

class UserService
{
    public function createUser(
        int $telegram_id = null,
        bool $is_bot = false,
        string $email = null,
        string $password = null
    ) {
        return User::create(
            [
                'telegram_id' => $telegram_id,
                'is_bot'      => $is_bot,
                'email'       => $email,
                'password'    => $password ? bcrypt($password) : null
            ]
        );
    }

    public function createProfile(
        User $user,
        string $first_name = null,
        string $last_name = null,
        string $username = null,
        string $language_code = 'en',
        string $language_from = 'ru',
        string $language_to = 'en',
        string $type = 'private'
    ) {
        $user->profile()->create([
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'username'      => $username,
            'language_code' => $language_code,
            'language_from' => $language_from,
            'language_to' => $language_to,
            'type'          => $type
        ]);
    }

    public function getUserByChatId(int $chat_id)
    {
        return User::ofChatId($chat_id)->first();
    }
}
