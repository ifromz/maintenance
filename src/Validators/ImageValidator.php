<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class ImageValidator.
 */
class ImageValidator extends FileValidator
{
    /**
     * {@inheritDoc}
     */
    protected $rules = [
        'files' => 'required|mimes:jpeg,jpg,png,gif,bmp,svg',
    ];
}
