<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class MeterValidator extends AbstractValidator {
    
    protected $rules = array(
        'metric' => 'required|integer',
        'name' => 'required|max:250',
        'reading' => 'positive'
    );
    
}