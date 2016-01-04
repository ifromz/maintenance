<?php

namespace App\Validators;

class PasswordValidator extends BaseValidator
{
    protected $rules = [
        'password'              => 'required|confirmed|min:8',
        'password_confirmation' => 'required|min:8',
    ];
}
