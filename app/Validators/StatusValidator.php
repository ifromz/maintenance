<?php

namespace App\Validators;

class StatusValidator extends BaseValidator
{
    protected $rules = [
        'name'  => 'required|max:250',
        'color' => 'required|max:20',
    ];
}
