<?php

namespace App\Validators\WorkOrder;

use App\Validators\BaseValidator;

class PartPutBackValidator extends BaseValidator
{
    protected $rules = [
        'quantity' => 'required|positive|greater_than:0',
    ];
}
