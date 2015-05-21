<?php

namespace Stevebauman\Maintenance\Controllers;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Illuminate\Support\Facades\File;

/**
 * Class AbstractUploadController.
 */
class AbstractUploadController extends BaseController
{
    /**
     * The name of the HTML file input.
     *
     * @var string
     */
    protected $fileInputName = 'files';

    /**
     * The base file storage location to store
     * the uploaded files. Must end with a trailing
     * slash.
     *
     * @var string
     */
    protected $baseFileStorageLocation = 'files/';

    /**
     * The location to store the uploaded files.
     * Must end with a trailing slash.
     *
     * @var string
     */
    protected $fileStorageLocation = 'temp/';

    /**
     * Performs the moving and renaming of uploaded files and returns
     * an array of all uploaded files names.
     *
     * @return array
     */
    public function uploadFiles()
    {
        $uploaded = [];

        $files = $this->inputFile($this->fileInputName);

        if (is_array($files) && count($files) > 0) {
            foreach ($files as $file) {
                $fileName = sprintf('%s.%s', uniqid(), $file->getClientOriginalExtension());

                try {
                    if ($file->move($this->getCompleteUploadDirectory(), $fileName)) {
                        $uploaded[] = $fileName;
                    }
                } catch (FileException $e) {
                }
            }
        }

        return $uploaded;
    }

    /**
     * Returns the target upload directory relative to the site URL.
     *
     * @return string
     */
    protected function getUploadDirectory()
    {
        return $this->baseFileStorageLocation.$this->fileStorageLocation;
    }

    /**
     * Returns the complete target upload directory.
     *
     * @return string
     */
    protected function getCompleteUploadDirectory()
    {
        return public_path($this->getUploadDirectory());
    }
}
