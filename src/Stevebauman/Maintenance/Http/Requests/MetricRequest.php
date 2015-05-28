<?php

namespace Stevebauman\Maintenance\Http\Requests;

class MetricRequest extends Request
{
    /**
     * The metric validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'symbol' => 'required|max:5',
        ];
    }

    /**
     * The
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
