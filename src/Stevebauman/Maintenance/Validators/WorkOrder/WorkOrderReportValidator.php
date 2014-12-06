<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class WorkOrderReportValidator extends BaseValidator { 
	
	protected $rules = array(
                'status' => 'required|integer',
                'description' => 'required|min:5|unique_report',
	);

}