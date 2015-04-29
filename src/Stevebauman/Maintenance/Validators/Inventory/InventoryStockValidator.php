<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class InventoryStockValidator
 * @package Stevebauman\Maintenance\Validators
 */
class InventoryStockValidator extends BaseValidator
{
    protected $rules = [
            'location_id' => 'integer|stock_location',
            'location' => 'required',
            'quantity' => 'required|positive',
            'reason' => 'max:250',
            'cost' => 'positive',
    ];
}
