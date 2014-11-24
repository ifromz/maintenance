<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class PriorityValidator extends AbstractValidator { 
	
	protected $rules = array(
                'name' => 'required|max:250|unique:priorities,name',
                'color' => 'required|max:250'
	);

}