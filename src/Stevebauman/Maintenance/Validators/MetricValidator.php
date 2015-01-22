<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class MetricValidator extends BaseValidator
{

    protected $rules = array(
        'name' => 'required|max:250|unique:metrics,name',
        'symbol' => 'required|max:5|unique:metrics,symbol'
    );

    public function passes()
    {
        return parent::passes();
    }
}