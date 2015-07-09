<?php

namespace Stevebauman\Maintenance\Validators;

class MetricValidator extends BaseValidator
{
    /**
     * The metrics validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:250',
        'symbol' => 'required|max:5',
    ];
}
