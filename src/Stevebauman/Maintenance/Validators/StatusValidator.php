<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class StatusValidator extends BaseValidator { 
	
	protected $rules = array(
                'name' => 'required|max:250',
                'color' => 'required|max:20'
	);

}