<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RhymesPageInfo extends Model
{
    protected $fillable = [
        'chat_id',
        'message_id',
        'page',
        'word'
    ];
}
