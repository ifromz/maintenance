<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class AuthLoginValidator extends AbstractValidator {
	
	protected $rules = array(
		'email' => 'required',
                'password' => 'required',
	);
	
}