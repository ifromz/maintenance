<?php

namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class NoteValidator extends BaseValidator {

    protected $rules = array(
        'content' => 'required|min:5',
    );

}