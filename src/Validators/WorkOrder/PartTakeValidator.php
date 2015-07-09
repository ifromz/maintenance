<?php

namespace Stevebauman\Maintenance\Validators\WorkOrder;

use Stevebauman\Maintenance\Validators\BaseValidator;

class PartTakeValidator extends BaseValidator
{
    protected $rules = [
        'quantity' => 'required|positive|greater_than:0|enough_quantity',
    ];
}
