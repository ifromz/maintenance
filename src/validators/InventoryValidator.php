<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class InventoryValidator extends AbstractValidator {
    
    protected $rules = array(
            'name' => 'required|max:250',
            'description' => '',
            'inventory_category' => 'required',
            'inventory_category_id' => 'integer',
            'metric' => 'integer'
	);
    
}
