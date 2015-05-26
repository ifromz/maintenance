<?php

namespace Stevebauman\Maintenance\Validators\WorkOrder;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class PartPutBackValidator.
*/
class PartPutBackValidator extends BaseValidator
{
    protected $rules = [
        'quantity' => 'required|positive|greater_than:0',
    ];
}
