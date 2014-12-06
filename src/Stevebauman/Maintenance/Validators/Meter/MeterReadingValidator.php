<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class MeterReadingValidator extends BaseValidator {
    
    protected $rules = array(
        'reading' => 'required|positive',
        'comment' => 'max:250'
    );
    
}