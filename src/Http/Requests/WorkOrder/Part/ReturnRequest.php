<?php

namespace Stevebauman\Maintenance\Http\Requests\WorkOrder\Part;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;

class ReturnRequest extends BaseRequest
{
    /**
     * The stock request validation rules.
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
     * Allows all users to attach stock to work orders.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
