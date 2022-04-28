<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TranslationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => 'min:3|max:100'
        ];
    }

    public function messages()
    {
        return [
            'value.min' => __('validation.min', ['min' => 3]),
            'value.max' => __('validation.max', ['max' => 100]),

        ];
    }
}
