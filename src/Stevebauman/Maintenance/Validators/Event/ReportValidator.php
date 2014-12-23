<?php

namespace Stevebauman\Maintenance\Validators\Event;

use Stevebauman\Maintenance\Validators\BaseValidator;

class ReportValidator extends BaseValidator {
    
    protected $rules = array(
        'description' => 'required|min:10'
    );
    
}