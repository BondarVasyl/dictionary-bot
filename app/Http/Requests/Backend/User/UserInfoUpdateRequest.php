<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserInfoUpdateRequest
 * @package App\Http\Requests\Backend\User
 */
class UserInfoUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'middle_name' => 'string|nullable',
            'phone' => 'string|nullable',
            'city' => 'string|nullable',
            'country' => 'string|nullable',
            'telegram' => 'string|nullable',
            'viber' => 'string|nullable',
            'about_me' => 'string|nullable',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => __('validation.required'),
            'name.required' => __('validation.required'),
            'email.email'   =>  __('validation.email'),
            'email.unique'  =>  __('validation.unique'),
            'name.max'      =>  __('validation.max', ['max' => 255])
        ];
    }
}
