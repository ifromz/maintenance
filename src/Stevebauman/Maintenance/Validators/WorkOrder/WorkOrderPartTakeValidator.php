<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class WorkOrderPartTakeValidator extends BaseValidator { 
	
	protected $rules = array(
    	'quantity' => 'required|positive|greater_than:0|enough_quantity',
	);

}