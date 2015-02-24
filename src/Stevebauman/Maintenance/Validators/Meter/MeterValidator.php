<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class MeterValidator
 * @package Stevebauman\Maintenance\Validators
 */
class MeterValidator extends BaseValidator
{
    
    protected $rules = array(
        'metric' => 'required|integer',
        'name' => 'required|max:250',
        'reading' => 'positive',
        'comment' => 'max:250'
    );
    
}