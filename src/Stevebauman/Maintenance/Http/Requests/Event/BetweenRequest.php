<?php

namespace Stevebauman\Maintenance\Http\Requests\Event;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;

class BetweenRequest extends BaseRequest
{
    /**
     * The between request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Allows all users to view events between two specified times.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
