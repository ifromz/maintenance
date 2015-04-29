<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class MeterReadingValidator
 * @package Stevebauman\Maintenance\Validators
 */
class MeterReadingValidator extends BaseValidator
{
    
    protected $rules = [
        'reading' => 'required|positive',
        'comment' => 'max:250'
    ];
    
}