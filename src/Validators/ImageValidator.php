<?php

namespace Stevebauman\Maintenance\Validators;

class ImageValidator extends FileValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'files' => 'required|mimes:jpeg,jpg,png,gif,bmp,svg',
    ];
}
