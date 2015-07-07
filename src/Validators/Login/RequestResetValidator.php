<?php

namespace Stevebauman\Maintenance\Validators\Login;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class RequestResetValidator.
 */
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
