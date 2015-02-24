<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class WorkOrderReportValidator
 * @package Stevebauman\Maintenance\Validators
 */
class WorkOrderReportValidator extends BaseValidator
{
	
	protected $rules = array(
        'status' => 'required|integer',
        'description' => 'required|min:5|unique_report',
	);

}