<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class InventoryValidator extends BaseValidator
{

    protected $rules = array(
        'name' => 'required|max:250',
        'description' => 'max:1000',
        'category' => 'required',
        'category_id' => 'integer',
        'metric' => 'required|integer'
    );

}
