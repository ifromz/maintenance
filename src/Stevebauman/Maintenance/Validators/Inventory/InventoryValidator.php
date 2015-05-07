<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class InventoryValidator.
 */
class InventoryValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
        'description' => 'max:1000',
        'category' => 'required',
        'category_id' => 'integer',
        'metric' => 'required|integer',
    ];
}
