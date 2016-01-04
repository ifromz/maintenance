<?php

namespace App\Validators;

class NoteValidator extends BaseValidator
{
    protected $rules = [
        'content' => 'required|min:5',
    ];
}
