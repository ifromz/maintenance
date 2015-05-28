<?php

namespace Stevebauman\Maintenance\Http\Requests\Meter;

use Stevebauman\Maintenance\Http\Requests\Request;

class ReadingRequest extends Request
{
    /**
     * The meter reading validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reading' => 'required|positive',
            'comment' => 'max:250',
        ];
    }

    /**
     * Allows all users to create meter readings.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
