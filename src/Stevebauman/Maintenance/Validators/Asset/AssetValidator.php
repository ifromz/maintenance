<?php

namespace Stevebauman\Maintenance\Validators;

class AssetValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|min:3|max:250',
        'condition' => 'required|integer|max:5|min:1',
        'category' => 'required',
        'category_id' => 'integer|min:1',
        'location' => 'required',
        'location_id' => 'integer|min:1',
    ];
}
