<?php

namespace Stevebauman\Maintenance\Validators\Login;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class AuthLoginValidator
 * @package Stevebauman\Maintenance\Validators
 */
class LoginValidator extends BaseValidator
{
	
	protected $rules = [
		'email' => 'required',
      	'password' => 'required',
    ];
	
}