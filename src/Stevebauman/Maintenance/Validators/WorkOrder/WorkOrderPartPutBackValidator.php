<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class WorkOrderPartPutBackValidator extends BaseValidator {
    
    protected $rules = array(
        'quantity' => 'required|positive|greater_than:0'
    );
    
}