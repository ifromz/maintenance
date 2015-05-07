<?php

namespace Stevebauman\Maintenance\Validators\Login;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class RequestResetValidator.
 */
class RequestResetValidator extends BaseValidator
{
    protected $rules = [
        'email' => 'required',
    ];
}
