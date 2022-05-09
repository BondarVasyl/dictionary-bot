<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'username',
        'language_code',
        'language_from',
        'language_to',
        'last_requested_word',
        'analyze_session_started',
        'type',
        'training_state',
        'translation_training_state'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFieldToWelcome()
    {
        if ($this->first_name) {
            return $this->first_name;
        }

        if ($this->last_name) {
            return $this->last_name;
        }

        if ($this->username) {
            return $this->username;
        }

        return __('bot_labels.welcome_user');
    }
}
