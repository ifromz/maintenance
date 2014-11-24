<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class CalendarValidator extends AbstractValidator {
    
    protected $rules = array(
        'name' => 'required|max:50',
        'description' => 'max:1000'
    );
    
}