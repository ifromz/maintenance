<?php

namespace Stevebauman\Maintenance\Validators\Event;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class ReportValidator
 * @package Stevebauman\Maintenance\Validators\Event
 */
class ReportValidator extends BaseValidator
{
    
    protected $rules = [
        'description' => 'required|min:10'
    ];
    
}