<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class WorkOrderPartPutBackValidator extends AbstractValidator {
    
    protected $rules = array(
        'quantity' => 'required|positive|greater_than:0'
    );
    
}