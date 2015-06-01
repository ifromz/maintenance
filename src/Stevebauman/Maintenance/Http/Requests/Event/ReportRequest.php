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
        $eventId = $this->route('event_id');

        return [
            'description' => "required|min:10|unique_event_report:$eventId",
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
