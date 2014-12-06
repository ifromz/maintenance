<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class AccessCheckValidator extends BaseValidator {
    
    protected $rules = array(
        'permission' => 'required'
    );
    
}