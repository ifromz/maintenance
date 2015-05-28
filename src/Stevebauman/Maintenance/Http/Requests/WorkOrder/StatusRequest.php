<?php

namespace Stevebauman\Maintenance\Http\Requests\WorkOrder;

use Stevebauman\Maintenance\Http\Requests\Request;

class StatusRequest extends Request
{
    /**
     * The status validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'color' => 'required|max:20',
        ];
    }

    /**
     * Allows all users to create work order statuses.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
