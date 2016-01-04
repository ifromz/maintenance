<?php

namespace App\Validators\Login;

use App\Validators\BaseValidator;

/**
 * Class AuthLoginValidator.
 */
class LoginValidator extends BaseValidator
{
    /**
     * The login validation rules.
     *
     * @var array
     */
    protected $rules = [
        'email'    => 'required',
        'password' => 'required',
    ];
}
