<?php

namespace App\Validators\WorkOrder;

use App\Validators\BaseValidator;

class CategoryValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|max:250',
    ];
}
