<?php

namespace Stevebauman\Maintenance\Http\Requests;

class AttachmentRequest extends Request
{
    /**
     * The mimes to allow for file uploads.
     *
     * @var array
     */
    protected $mimes = [
        'pdf',
        'txt',
        'doc',
        'docx',
        'xlx',
        'xlsx',
        'ppt',
        'pptx',
        'jpg',
        'jpeg',
        'gif',
        'png',
    ];

    /**
     * The upload validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $mimes = $this->getMimes();

        $rules = [];

        if($this->hasFile('files')) {
            $files = $this->file('files');

            foreach($files as $key => $file) {
                $rules['files.' . $key] = "required|mimes:$mimes";
            }
        }

        return $rules;
    }

    /**
     * Allows all users to upload files.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Returns the valid mimes in a single string.
     *
     * @return string
     */
    public function getMimes()
    {
        return implode(',', $this->mimes);
    }
}
