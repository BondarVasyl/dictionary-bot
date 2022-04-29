<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'telegram_id',
        'is_bot',
        'email',
        'password',
        'created_at',
        'updated_at',
    ];

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function profile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function dictionary(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Dictionary::class);
    }

    public function scopeOfChatId($query, $chat_id)
    {
        return $query->where('telegram_id', $chat_id);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
