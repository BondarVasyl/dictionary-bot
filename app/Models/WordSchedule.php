<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WordSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'dictionary_id',
        'date',
        'time',
        'type',
        'status'
    ];

    private $types = [
        'simple',
        'word_with_translation'
    ];

    public const SIMPLE_TYPE = 'simple';
    public const WORD_WITH_TRANSLATION_TYPE = 'word_with_translation';

    public function dictionary(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Dictionary::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSimpleWords(Builder $builder): Builder
    {
        return $builder->where('type', 'simple');
    }

    public function scopeWordsWithTranslation(Builder $builder): Builder
    {
        return $builder->where('type', 'word_with_translation');
    }
}
