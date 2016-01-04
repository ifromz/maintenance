<?php

namespace App\Validators;

class AssignmentValidator extends BaseValidator
{
    protected $rules = [
            'users' => 'required|user_assignment',
    ];
}
