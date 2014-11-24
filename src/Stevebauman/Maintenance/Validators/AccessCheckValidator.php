<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class AccessCheckValidator extends AbstractValidator {
    
    protected $rules = array(
        'permission' => 'required'
    );
    
}