<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class AssignmentValidator extends BaseValidator {
	
	protected $rules = array(
            'users' => 'required|user_assignment',
	);
	
}