<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class AuthLoginValidator extends BaseValidator {
	
	protected $rules = array(
		'email' => 'required',
      	'password' => 'required',
	);
	
}