<?php

namespace Stevebauman\Maintenance\Validators;

class AccessCheckValidator extends BaseValidator
{
    protected $rules = [
        'permission' => 'required',
    ];
}
