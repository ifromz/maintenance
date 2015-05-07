<?php

namespace Stevebauman\Maintenance\Validators\Login;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class AuthLoginValidator.
 */
class LoginValidator extends BaseValidator
{
    protected $rules = [
        'email' => 'required',
          'password' => 'required',
    ];
}
