<?php

namespace Stevebauman\Maintenance\Http\Requests\Asset;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * The asset validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:250',
            'condition' => 'required|integer|max:5|min:1',
            'category' => 'required',
            'category_id' => 'integer|min:1',
            'location' => 'required',
            'location_id' => 'integer|min:1',
        ];
    }

    /**
     * Allows all users to create an asset.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
