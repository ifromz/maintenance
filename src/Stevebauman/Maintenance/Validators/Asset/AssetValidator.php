<?php namespace Stevebauman\Maintenance\Validators;

class AssetValidator extends BaseValidator
{

    protected $rules = [
        'name' => 'required|min:3|max:250',
        'condition' => 'required|integer',
        'category' => 'required',
        'category_id' => 'integer',
        'location' => 'required',
        'location_id' => 'integer'
    ];

}