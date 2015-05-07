<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class WorkOrderPartTakeValidator.
 */
class WorkOrderPartTakeValidator extends BaseValidator
{
    protected $rules = [
        'quantity' => 'required|positive|greater_than:0|enough_quantity',
    ];
}
