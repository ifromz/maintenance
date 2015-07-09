<?php

namespace Stevebauman\Maintenance\Validators;

class DocumentValidator extends FileValidator
{
    /**
     * {@inheritDoc}
     */
    protected $rules = [
        'files' => 'required|mimes:pdf,doc,docx,xls,xlsx',
    ];
}
