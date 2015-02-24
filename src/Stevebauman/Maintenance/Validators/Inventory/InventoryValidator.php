<?php namespace Stevebauman\Maintenance\Validators;

/**
 * Class InventoryValidator
 * @package Stevebauman\Maintenance\Validators
 */
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
