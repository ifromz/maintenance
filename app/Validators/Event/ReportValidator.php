<?php

namespace App\Validators\Event;

use App\Validators\BaseValidator;

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
