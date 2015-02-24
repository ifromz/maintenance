<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class NoteValidator
 * @package Stevebauman\Maintenance\Validators
 */
class NoteValidator extends BaseValidator
{

    protected $rules = array(
        'content' => 'required|min:5',
    );

}