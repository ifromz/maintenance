<?php

namespace Stevebauman\Maintenance\Validators;

class CategoryValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
    ];
}
