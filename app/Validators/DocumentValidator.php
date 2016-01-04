<?php

namespace App\Validators;

class DocumentValidator extends FileValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'files' => 'required|mimes:pdf,doc,docx,xls,xlsx',
    ];
}
