<?php

namespace Stevebauman\Maintenance\Http\Requests\Event;

use Stevebauman\Maintenance\Http\Requests\Request;

class ReportRequest extends Request
{
    /**
     * The report validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|min:10',
        ];
    }

    /**
     * Allows all users to create reports for events.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
