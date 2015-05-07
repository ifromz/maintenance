<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class MeterReadingValidator.
 */
class MeterReadingValidator extends BaseValidator
{
    protected $rules = [
        'reading' => 'required|positive',
        'comment' => 'max:250',
    ];
}
