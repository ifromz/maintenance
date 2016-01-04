<?php

namespace App\Validators\Login;

use App\Validators\BaseValidator;

class RequestResetValidator extends BaseValidator
{
    /**
     * The reset validation rules.
     *
     * @var array
     */
    protected $rules = [
        'email' => 'required',
    ];
}
