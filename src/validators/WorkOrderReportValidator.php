<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class WorkOrderReportValidator extends AbstractValidator { 
	
	protected $rules = array(
                'status' => 'required|integer',
                'description' => 'required|min:5|unique_report',
	);

}