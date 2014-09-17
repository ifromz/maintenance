<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class WorkOrderValidator extends AbstractValidator { 
	
	protected $rules = array(
                'work_order_category' => 'required|alpha_dash',
		'work_order_category_id' => 'integer',
		'status' => 'required|integer',
		'subject' => 'required|min:5|alpha_dash',
		'description'=> 'min:5',
		
		'started_at_date' => '',
		'started_at_time' => '',
		
		'completed_at_date' => '',
		'completed_at_time' => '',
	);

}