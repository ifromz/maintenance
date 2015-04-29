<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class LocationValidator
 * @package Stevebauman\Maintenance\Validators
 */
class LocationValidator extends BaseValidator
{
	
	protected $rules = [
		'name' => 'required|max:250',
    ];
	
}