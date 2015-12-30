<?php

namespace Stevebauman\Maintenance\Http\Requests\Inventory;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * The inventory validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|max:250',
            'description' => 'max:1000',
            'category'    => 'required',
            'category_id' => 'min:1|integer|exists:categories,id',
            'metric'      => 'required|integer|exists:metrics,id',
        ];
    }

    /**
     * Allows all users to create an inventory item.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
