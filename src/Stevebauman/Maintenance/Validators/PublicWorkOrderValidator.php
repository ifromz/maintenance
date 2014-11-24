<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class PublicWorkOrderValidator extends AbstractValidator {
    
    protected $rules = array(
        'subject' => 'required|min:5|max:250',
        'description' => 'min:10|max:2000'
    );
    
}