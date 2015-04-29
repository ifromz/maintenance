<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class GroupValidator
 * @package Stevebauman\Maintenance\Validators
 */
class GroupValidator extends BaseValidator
{
	
	protected $rules = [
		'name' => 'required|min:3|max:250'
    ];
	
}