<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class MetricValidator extends AbstractValidator {
    
    protected $rules = array(
        'name' => 'required|max:250|unique:metrics,name',
        'symbol' => 'required|max:5|unique:metrics,symbol'
    );
    
}