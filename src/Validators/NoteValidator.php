<?php

namespace Stevebauman\Maintenance\Validators;

class NoteValidator extends BaseValidator
{
    protected $rules = [
        'content' => 'required|min:5',
    ];
}
