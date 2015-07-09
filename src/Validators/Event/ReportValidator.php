<?php

namespace Stevebauman\Maintenance\Validators\Event;

use Stevebauman\Maintenance\Validators\BaseValidator;

class ReportValidator extends BaseValidator
{
    /**
     * The report validation rules.
     *
     * @var array
     */
    protected $rules = [
        'description' => 'required|min:10',
    ];
}
