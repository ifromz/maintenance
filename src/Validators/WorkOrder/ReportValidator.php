<?php

namespace Stevebauman\Maintenance\Validators\WorkOrder;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class ReportValidator.
 */
class ReportValidator extends BaseValidator
{
    protected $rules = [
        'status' => 'required|integer',
        'description' => 'required|min:5|unique_report',
    ];
}
