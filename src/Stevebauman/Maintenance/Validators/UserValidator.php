<?php

namespace Stevebauman\Maintenance\Validators;

class UserValidator extends BaseValidator
{
    protected $rules = array(
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'username' => 'required|min:5|unique:users',
        'email' => 'required|min:5|email|unique:users',
        'password' => 'confirmed|required_with:activated|min:8',
        'password_confirmation' => 'required_with:activated|min:8',
        'activated' => 'integer|boolean',
    );
}