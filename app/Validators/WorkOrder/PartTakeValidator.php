<?php

namespace App\Validators\WorkOrder;

use App\Validators\BaseValidator;

class PartTakeValidator extends BaseValidator
{
    protected $rules = [
        'quantity' => 'required|positive|greater_than:0|enough_quantity',
    ];
}
