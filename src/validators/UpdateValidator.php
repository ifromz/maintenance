<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class UpdateValidator extends AbstractValidator { 
	
	protected $rules = array(
		'update_content' => 'required|max:400',
	);

}