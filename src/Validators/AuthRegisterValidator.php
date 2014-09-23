<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class AuthRegisterValidator extends AbstractValidator {
	
	protected $rules = array(
                'first_name' => 'required',
                'last_name' => 'required',
		'email' => 'required|email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
	);
	
}