<?php

namespace App\Http\Requests\Backend\Variable;

use App\Models\Variable;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VariableUpdateRequest
 * @package App\Http\Requests\Variable
 */
class VariableUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('variable');

        return [
            'type'         => 'required|in:'.implode(',', array_keys(app(Variable::class)->getTypes())),
            'key'          => 'required|unique:variables,key,'.$id.',id',
            'name'         => 'required|string',
            'multilingual' => 'required|boolean',
        ];
    }
}
