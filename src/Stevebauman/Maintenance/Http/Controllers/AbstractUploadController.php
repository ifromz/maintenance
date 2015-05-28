<?php

namespace Stevebauman\Maintenance\Http\Controllers;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Carbon\Carbon;

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
                if($file instanceof UploadedFile) {
                    // Retrieve the uploaded files details
                    $fileName = $file->getClientOriginalName();
                    $fileExt = $file->getClientOriginalExtension();

                    // Remove the client file extension to retrieve just the file name
                    $prefix = str_replace('.'.$fileExt, null, $fileName.'-');

                    // Create the date suffix
                    $suffix = Carbon::now()->format('Y-m-d');

                    // Create the unique identifier for possibility of same uploaded file names
                    $uniqueId = uniqid('-');

                    // Create the new file name
                    $newFileName = sprintf('%s.%s', $prefix.$suffix.$uniqueId, $fileExt);

                    try {
                        // Try and move the file to the upload directory with the new file name
                        if ($file->move($this->getCompleteUploadDirectory(), $newFileName)) {
                            // Move was a success, we'll add it to the uploaded files array
                            $uploaded[] = $newFileName;
                        }
                    } catch (FileException $e) {
                    }
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
