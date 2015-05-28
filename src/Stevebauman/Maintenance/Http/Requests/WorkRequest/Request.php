<?php

namespace Stevebauman\Maintenance\Http\Requests\WorkRequest;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * The work request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required|min:10',
            'description' => 'required|min:10',
            'best_time' => 'min:4',
        ];
    }

    /**
     * Allows all users to create work requests.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
