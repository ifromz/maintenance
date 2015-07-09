<?php

namespace Stevebauman\Maintenance\Validators;

class AssignmentValidator extends BaseValidator
{
    protected $rules = [
            'users' => 'required|user_assignment',
    ];
}
