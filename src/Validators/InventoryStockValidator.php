<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class InventoryStockValidator extends AbstractValidator {
    
    protected $rules = array(
            'location_id' => 'integer|stock_location',
            'location' => 'required',
            'quantity' => 'required|positive',
            'reason' => 'max:250',
            'cost' => 'positive',
        );
    
}
