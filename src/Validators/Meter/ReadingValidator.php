<?php

namespace Stevebauman\Maintenance\Validators\Meter;

use Stevebauman\Maintenance\Validators\BaseValidator;

class ReadingValidator extends BaseValidator
{
    /**
     * The reading validation rules.
     *
     * @var array
     */
    protected $rules = [
        'reading' => 'required|positive',
        'comment' => 'max:250',
    ];
}
