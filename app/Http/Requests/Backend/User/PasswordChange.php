<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PasswordChangeFromCodeRequest
 * @package App\Http\Requests\Backend\User
 */
class PasswordChange extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'              => 'required|confirmed:password_confirmation|min:5',
            'password_confirmation' => 'required',
        ];
    }
}
