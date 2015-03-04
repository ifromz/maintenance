<?php

namespace Stevebauman\Maintenance\Validators\Login;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class AuthRegisterValidator
 * @package Stevebauman\Maintenance\Validators
 */
class RegisterValidator extends BaseValidator
{
	protected $rules = array(
        'first_name' => 'required|max:100',
        'last_name' => 'required|max:100',
        'email' => 'required|email|max:250',
        'password' => 'required|confirmed|max:250',
        'password_confirmation' => 'required|max:250',
        'g-recaptcha-response' => 'required|captcha'
	);
}