<?php

namespace Stevebauman\Maintenance\Http\Requests;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;

class AttachmentUpdateRequest extends BaseRequest
{
    /**
     * The upload update validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
        ];
    }

    /**
     * Allows all users to update their uploads.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
