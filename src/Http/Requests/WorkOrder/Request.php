<?php

namespace Stevebauman\Maintenance\Http\Requests\WorkOrder;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * The work order validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category'    => '',
            'category_id' => 'integer|min:1|exists:categories,id',

            'location'    => '',
            'location_id' => 'integer|min:1|exists:locations,id',

            'status'   => 'required|integer|exists:statuses,id',
            'priority' => 'required|integer|exists:priorities,id',

            'subject'     => 'required|min:5|max:250',
            'description' => 'min:5',

            'started_at_date' => '',
            'started_at_time' => '',

            'completed_at_date' => '',
            'completed_at_time' => '',
        ];
    }

    /**
     * Authorizes all users to create a work order.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
