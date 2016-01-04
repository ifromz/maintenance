<?php

namespace App\Validators\WorkOrder;

use App\Validators\BaseValidator;

class ReportValidator extends BaseValidator
{
    protected $rules = [
        'status'      => 'required|integer',
        'description' => 'required|min:5|unique_report',
    ];
}
