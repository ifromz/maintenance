<?php

namespace Stevebauman\Maintenance\Http\Requests\Admin;

use Stevebauman\Maintenance\Http\Requests\Request;

class GroupRequest extends Request
{
    /**
     * The group validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:250',
        ];
    }

    /**
     * Allows all users to create groups.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
