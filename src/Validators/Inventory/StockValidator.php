<?php

namespace Stevebauman\Maintenance\Validators\Inventory;

use Stevebauman\Maintenance\Validators\BaseValidator;

class StockValidator extends BaseValidator
{
    /**
     * The stock validation rules.
     *
     * @var array
     */
    protected $rules = [
        'location_id' => 'integer|min:1|stock_location',
        'location'    => 'required',
        'quantity'    => 'required|positive',
        'reason'      => 'max:250',
        'cost'        => 'positive',
    ];
}
