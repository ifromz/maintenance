<?php

namespace Stevebauman\Maintenance\Http\Requests\Inventory\Stock;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;

class PutRequest extends BaseRequest
{
    /**
     * The stock put validation rules.
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
     * Allows all users to put inventory stock.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
