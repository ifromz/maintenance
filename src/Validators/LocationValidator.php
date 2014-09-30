<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class LocationValidator extends AbstractValidator {
	
	protected $rules = array(
		'name' => 'required|max:250',
	);
	
}