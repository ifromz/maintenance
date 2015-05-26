<?php

namespace Stevebauman\Maintenance\Validators\WorkOrder;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class CategoryValidator.
 */
class CategoryValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
    ];
}
