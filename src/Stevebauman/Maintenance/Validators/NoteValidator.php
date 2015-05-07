<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class NoteValidator.
 */
class NoteValidator extends BaseValidator
{
    protected $rules = [
        'content' => 'required|min:5',
    ];
}
