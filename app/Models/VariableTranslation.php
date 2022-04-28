<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VariableTranslation
 * @package App\Models
 */
class VariableTranslation extends Model
{
    
    /**
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * @var array
     */
    protected $fillable = ['text','json'];

	public $casts = [
		'json' => 'array'
	];
}