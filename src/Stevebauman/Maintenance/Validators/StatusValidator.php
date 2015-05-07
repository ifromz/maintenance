<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class StatusValidator.
 */
class StatusValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
        'color' => 'required|max:20',
    ];
}
