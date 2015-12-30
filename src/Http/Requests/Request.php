<?php

namespace Stevebauman\Maintenance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;

abstract class Request extends FormRequest
{
    /**
     * Cleans a string or array of HTML input.
     *
     * @param string|array $input
     *
     * @return string|array
     */
    public function clean($input)
    {
        return Purify::clean($input);
    }
}
