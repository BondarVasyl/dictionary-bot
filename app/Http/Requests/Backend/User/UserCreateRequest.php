<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserCreateRequest
 * @package App\Http\Requests\Backend\User
 */
class UserCreateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'email'    => 'required|email|unique:users',
            'name'     => 'required|string|max:255',
            'password' => 'required|confirmed|min:' . config('auth.passwords.min_length'),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'     => __('validation.required'),
            'name.required'      => __('validation.required'),
            'password.required'  => __('validation.required'),
            'password.confirmed' => __('validation.confirmed'),
            'email.email'   =>  __('validation.email'),
            'email.unique'  =>  __('validation.unique'),
            'name.max'      =>  __('validation.max', ['max' => 255]),
            'password.min'  =>  __('validation.min', ['min' => config('auth.passwords.min_length')])
        ];
    }
}
