<?php

namespace Stevebauman\Maintenance\Http\Requests\Inventory\Stock;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * The inventory stock validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location_id' => 'integer|min:1|stock_location',
            'location' => 'required',
            'quantity' => 'required|positive',
            'reason' => 'max:250',
            'cost' => 'positive',
        ];
    }

    /**
     * Allows all users to create a stock on an inventory item.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
