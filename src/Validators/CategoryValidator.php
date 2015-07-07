<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class CategoryValidator.
 */
class CategoryValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
    ];
}
