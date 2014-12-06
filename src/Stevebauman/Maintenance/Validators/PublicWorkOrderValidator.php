<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class PublicWorkOrderValidator extends BaseValidator {
    
    protected $rules = array(
        'subject' => 'required|min:5|max:250',
        'description' => 'min:10|max:2000'
    );
    
}