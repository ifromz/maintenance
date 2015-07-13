<?php

namespace Stevebauman\Maintenance\Validators;

class UpdateValidator extends BaseValidator
{
    /**
     * The update validation rules.
     *
     * @var array
     */
    protected $rules = [
        'update_content' => 'required|max:1000',
    ];
}
