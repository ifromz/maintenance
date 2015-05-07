<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class WorkOrderPartPutBackValidator.
 */
class WorkOrderPartPutBackValidator extends BaseValidator
{
    protected $rules = [
        'quantity' => 'required|positive|greater_than:0',
    ];
}
