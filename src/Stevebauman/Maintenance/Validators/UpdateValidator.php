<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class UpdateValidator extends BaseValidator { 
	
	protected $rules = array(
		'update_content' => 'required|max:1000',
	);

}