<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = ['key','value'];

    public static function getSettings($key = null): \Illuminate\Support\Collection
    {
        $settings = $key ? self::where('key', $key)->first() : self::get();

        $collect = collect();

        foreach ($settings as $setting) {
            $collect->put($setting->key, $setting->value);
        }

        return $collect;
    }

    public function deleteHookSetting()
    {
        $this->where('key', '!=', null)->delete();
    }

    public function createNewSetting($key, $domen)
    {
        $this->create([
            'key'   => $key,
            'value' => $domen
        ]);
    }
}
