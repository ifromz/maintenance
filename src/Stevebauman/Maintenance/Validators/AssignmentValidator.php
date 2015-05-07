<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class AssignmentValidator.
 */
class AssignmentValidator extends BaseValidator
{
    protected $rules = [
            'users' => 'required|user_assignment',
    ];
}
