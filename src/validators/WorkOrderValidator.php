<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class WorkOrderValidator extends AbstractValidator { 
	
	protected $rules = array(
                'work_order_category' => 'required',
		'work_order_category_id' => 'required|integer',
		'status' => 'required|not_in:0',
		'subject' => 'required|min:5',
		'description'=> 'min:5',
		
		'started_at_date' => '',
		'started_at_time' => '',
		
		'completed_at_date' => '',
		'completed_at_time' => '',
	);

}