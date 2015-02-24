<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class AccessCheckValidator
 * @package Stevebauman\Maintenance\Validators
 */
class AccessCheckValidator extends BaseValidator
{
    
    protected $rules = array(
        'permission' => 'required'
    );
    
}