<?php

namespace App\Models;

use App\Models\Traits\PositionSortedTrait;
use App\Models\Traits\WithTranslationsTrait;
use App\Models\Traits\WithTypes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * Class Variable
 * @package App\Models
 */
class Variable extends Model implements TranslatableContract
{

    use Translatable;
    use WithTranslationsTrait;
    use PositionSortedTrait;
    use WithTypes;

    /**
     * @var array
     */
    public $translatedAttributes = ['text','json'];

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'key',
        'name',
        'description',
        'multilingual',
        'value',
        'text',
        'status',
        'position',
		'aim',
    ];

    /**
     * @var int
     */
    public static $defaultType = 1;

    /**
     * @var array
     */
    protected $types = [
        1  => 'text',
        2  => 'editor',
        3  => 'image',
        4  => 'weekday',
        5  => 'time',
        6  => 'boolean',
        7  => 'commission_type',
        8  => 'multi_select',
        9  => 'file',
        10 => 'range',
        11 => 'img_button',
        12 => 'textarea',
        13 => 'date'
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotHidden(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    /**
     * @param string $value
     */
    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = preg_replace('/\W+\./', '_', $value);
    }

    /**
     * @param string $value
     */
    public function setValueAttribute($value)
    {
        switch ($this->getStringType()) {
            case 'multi_select':
                $value = (empty($value) ? '[]' : json_encode($value));

                break;

            case 'range':
                $value = is_array($value) ? $value : [];

                $value = [
                    'from' => array_get($value, 'from'),
                    'to'   => array_get($value, 'to'),
                ];

                $value = json_encode($value);

                break;

            case 'img_button':
                $value = is_array($value) ? $value : [];

                $value = [
                    'image' => asset(array_get($value, 'image')),
                    'url' => array_get($value, 'url'),
                ];

                $value = json_encode($value);

                break;
        };

        $this->attributes['value'] = $value;
    }

    /**
     * @param mixed $value
     *
     * @return  mixed
     */
    public function getValueAttribute($value)
    {
        if ($this->multilingual) {
            return $this->text;
        }

        if ($this->getStringType() == 'multi_select') {
            if (empty($value)) {
                return [];
            }

            $values = [];

            foreach (json_decode($value, true) as $value) {
                $values[$value] = $value;
            }

            return $values;
        }

        if (array_search($this->getStringType(),  ['range', 'img_button']) !== false) {
            return json_decode($value, true);
        }

        return $value;
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeVisible($query)
    {
        return $query->where($this->getTable().'.status', true);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeForContent($query)
    {
        return $query->where($this->getTable().'.aim', '=', 'content');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeForSettings($query)
    {
        return $query->where($this->getTable().'.aim', '=', 'settings');
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    private static function prepareData($key, array $value)
    {
        $data = [
            'key' => $key,
            'name' => $value['name'],
            'type' => $value['type']
        ];

        $data = isset($value['localization'])
            ? array_merge($data, ['multilingual' => true], $value['localization'])
            : array_merge($data, ['value' => $value['plain_value']]);

        return $data;
    }

    public static function getValueByKey($key)
    {
        $variabe = self::where('key', $key)->first();

        if (!$variabe) {
            $configValue = config('variables.' . $key);

            if ($configValue) {
                $data = self::prepareData($key, $configValue);
                $variabe = self::create($data);

                return $variabe->value;
            } else {
                return null;
            }
        }

        return $variabe->value;
    }
}
