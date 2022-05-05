<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'dictionary_id',
        'date',
        'time',
        'status'
    ];

    public function dictionary(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Dictionary::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
