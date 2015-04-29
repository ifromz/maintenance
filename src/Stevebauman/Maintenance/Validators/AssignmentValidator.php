<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class AssignmentValidator
 * @package Stevebauman\Maintenance\Validators
 */
class AssignmentValidator extends BaseValidator
{
	
	protected $rules = [
            'users' => 'required|user_assignment',
    ];
	
}