<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class WorkOrderPartTakeValidator
 * @package Stevebauman\Maintenance\Validators
 */
class WorkOrderPartTakeValidator extends BaseValidator
{
	
	protected $rules = array(
    	'quantity' => 'required|positive|greater_than:0|enough_quantity',
	);

}