<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class WorkOrderValidator
 * @package Stevebauman\Maintenance\Validators
 */
class WorkOrderValidator extends BaseValidator
{

    protected $rules = [
        'category' => '',
        'category_id' => 'integer',

        'location' => '',
        'location_id' => 'integer',

        'status' => 'required|integer',
        'priority' => 'required|integer',

        'subject' => 'required|min:5|max:250',
        'description' => 'min:5',

        'started_at_date' => '',
        'started_at_time' => '',

        'completed_at_date' => '',
        'completed_at_time' => '',
    ];

}