<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class WorkOrderReportValidator.
 */
class WorkOrderReportValidator extends BaseValidator
{
    protected $rules = [
        'status' => 'required|integer',
        'description' => 'required|min:5|unique_report',
    ];
}
