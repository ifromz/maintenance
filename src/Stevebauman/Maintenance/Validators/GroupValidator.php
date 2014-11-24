<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class GroupValidator extends AbstractValidator {
	
	protected $rules = array(
		'name' => 'required|min:3|max:250'
	);
	
}