<?php

namespace Stevebauman\Maintenance\Validators;

class UpdateValidator extends BaseValidator
{
	
	protected $rules = array(
		'update_content' => 'required|max:1000',
	);

}