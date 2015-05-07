<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class AccessCheckValidator.
 */
class AccessCheckValidator extends BaseValidator
{
    protected $rules = [
        'permission' => 'required',
    ];
}
