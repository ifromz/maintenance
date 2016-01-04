<?php

namespace App\Validators\Meter;

use App\Validators\BaseValidator;

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
