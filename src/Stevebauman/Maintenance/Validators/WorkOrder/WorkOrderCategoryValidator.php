<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class WorkOrderCategoryValidator extends BaseValidator {
	
	protected $rules = array(
		'name' => 'required|max:250',
	);
	
}