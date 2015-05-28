<?php

namespace Stevebauman\Maintenance\Http\Requests\WorkOrder;

use Stevebauman\Maintenance\Http\Requests\Request;

class CategoryRequest extends Request
{
    /**
     * The category validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
        ];
    }

    /**
     * Authorizes all users to create categories.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
