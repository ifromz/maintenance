<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class StatusValidator extends AbstractValidator { 
	
	protected $rules = array(
                'name' => 'required|max:250',
                'control' => 'required|integer'
	);

}