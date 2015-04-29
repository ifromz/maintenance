<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class MetricValidator
 * @package Stevebauman\Maintenance\Validators
 */
class MetricValidator extends BaseValidator
{

    protected $rules = [
        'name' => 'required|max:250|unique:metrics,name',
        'symbol' => 'required|max:5|unique:metrics,symbol'
    ];

}