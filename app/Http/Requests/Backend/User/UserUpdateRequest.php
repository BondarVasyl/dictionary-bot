<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserUpdateRequest
 * @package App\Http\Requests\Backend\User
 */
class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route()->parameter('user')->id;

        return [
            'email'      => 'required|email|unique:users,email,' . $id,
            'name'       => 'required|string|max:255',
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
