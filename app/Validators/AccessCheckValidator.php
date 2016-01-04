<?php

namespace App\Validators;

class AccessCheckValidator extends BaseValidator
{
    protected $rules = [
        'permission' => 'required',
    ];
}
