<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class MeterValidator extends BaseValidator {
    
    protected $rules = array(
        'metric' => 'required|integer',
        'name' => 'required|max:250',
        'reading' => 'positive',
        'comment' => 'max:250'
    );
    
}