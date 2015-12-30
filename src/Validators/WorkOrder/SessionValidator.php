<?php

namespace Stevebauman\Maintenance\Validators\WorkOrder;

use Stevebauman\Maintenance\Validators\BaseValidator;

class SessionValidator extends BaseValidator
{
    /**
     * The work order session
     * validation rules.
     *
     * @var array
     */
    protected $rules = [
        'work_order_id' => 'required|integer',
    ];
}
