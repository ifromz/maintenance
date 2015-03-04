<?php

namespace Stevebauman\Maintenance\Validators\Login;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class RequestResetValidator
 * @package Stevebauman\Maintenance\Validators\Login
 */
class RequestResetValidator extends BaseValidator
{
    protected $rules = array(
        'email' => 'required'
    );
}