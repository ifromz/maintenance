<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class GroupValidator extends BaseValidator {
	
	protected $rules = array(
		'name' => 'required|min:3|max:250'
	);
	
}