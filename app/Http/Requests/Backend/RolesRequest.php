<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest
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
            'title' => 'required|min:3|max:100'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.required'),
            'title.min' => __('validation.min', ['min' => 3]),
            'title.max' => __('validation.max', ['max' => 100]),
        ];
    }
}
