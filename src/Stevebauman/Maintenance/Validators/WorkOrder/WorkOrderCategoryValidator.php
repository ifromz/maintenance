<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class WorkOrderCategoryValidator.
 */
class WorkOrderCategoryValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
    ];
}
