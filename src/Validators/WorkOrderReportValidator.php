<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class WorkOrderReportValidator extends AbstractValidator { 
	
	protected $rules = array(
                'description' => 'required|min:10|unique_report',
	);

}