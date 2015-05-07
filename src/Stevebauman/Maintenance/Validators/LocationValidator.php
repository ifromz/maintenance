<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class LocationValidator.
 */
class LocationValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
    ];
}
