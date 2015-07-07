<?php

namespace Stevebauman\Maintenance\Http\Requests\Inventory\Stock;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;

class TakeRequest extends BaseRequest
{
    /**
     * The stock take validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'required|positive',
        ];
    }

    /**
     * Allows all users to take inventory stock.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
