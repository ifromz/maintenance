<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class WorkOrderCategoryValidator
 * @package Stevebauman\Maintenance\Validators
 */
class WorkOrderCategoryValidator extends BaseValidator
{
	
	protected $rules = array(
		'name' => 'required|max:250',
	);
	
}