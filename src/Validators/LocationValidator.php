<?php

namespace Stevebauman\Maintenance\Validators;

class LocationValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
    ];
}
