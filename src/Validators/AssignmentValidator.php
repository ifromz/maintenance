<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class AssignmentValidator extends AbstractValidator {
	
	protected $rules = array(
            'users' => 'required|user_assignment',
	);
	
}