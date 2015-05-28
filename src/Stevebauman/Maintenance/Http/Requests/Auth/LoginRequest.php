<?php

namespace Stevebauman\Maintenance\Http\Requests\Auth;

use Stevebauman\Maintenance\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * The login validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * Allows all users to login.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
