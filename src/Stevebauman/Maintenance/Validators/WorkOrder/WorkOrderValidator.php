<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class WorkOrderValidator extends BaseValidator { 
	
	protected $rules = array(
                'work_order_category' => '',
		'work_order_category_id' => 'integer',
                
                'location' => '',
                'location_id' => 'integer',
            
		'status' => 'required|integer',
                'priority' => 'required|integer',
            
		'subject' => 'required|min:5|max:250',
		'description'=> 'min:5',
		
		'started_at_date' => '',
		'started_at_time' => '',
		
		'completed_at_date' => '',
		'completed_at_time' => '',
	);

}