<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class WorkOrderPartValidator extends AbstractValidator { 
	
	protected $rules = array(
                'quantity' => 'required|positive|greater_than:0|enough_quantity',
	);

}