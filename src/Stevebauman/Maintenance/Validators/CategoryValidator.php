<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class CategoryValidator
 * @package Stevebauman\Maintenance\Validators
 */
class CategoryValidator extends BaseValidator
{
	
	protected $rules = array(
		'name' => 'required|max:250',
	);
	
}