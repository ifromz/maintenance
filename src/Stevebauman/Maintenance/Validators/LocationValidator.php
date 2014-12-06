<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class LocationValidator extends BaseValidator {
	
	protected $rules = array(
		'name' => 'required|max:250',
	);
	
}