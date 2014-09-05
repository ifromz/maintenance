<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class WorkOrderCategoryValidator extends AbstractValidator {
	
	protected $rules = array(
		'name' => 'required|max:20|alpha_dash',
	);
	
}