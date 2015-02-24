<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class AuthLoginValidator
 * @package Stevebauman\Maintenance\Validators
 */
class AuthLoginValidator extends BaseValidator
{
	
	protected $rules = array(
		'email' => 'required',
      	'password' => 'required',
	);
	
}