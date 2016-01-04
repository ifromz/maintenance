<?php

namespace App\Validators\WorkOrder;

use App\Validators\BaseValidator;

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
