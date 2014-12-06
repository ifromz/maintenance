<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class CalendarValidator extends BaseValidator {
    
    protected $rules = array(
        'name' => 'required|max:50',
        'description' => 'max:1000'
    );
    
}