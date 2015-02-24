<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class LocationValidator
 * @package Stevebauman\Maintenance\Validators
 */
class LocationValidator extends BaseValidator
{
	
	protected $rules = array(
		'name' => 'required|max:250',
	);
	
}