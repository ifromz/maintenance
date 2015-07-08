<?php

namespace Stevebauman\Maintenance\Repositories;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Stevebauman\Maintenance\Models\Attachment;

class AttachmentRepository extends Repository
{
    /**
     * The base directory to store uploaded files.
     *
     * @var string
     */
    protected $baseDir = 'files';

    /**
     * The timestamp format to store the uploaded
     * date and time inside the uploaded file names.
     *
     * @var string
     */
    protected $timestampFormat = 'U';

    /**
     * @return Attachment
     */
    public function model()
    {
        return new Attachment();
    }

    /**
     * Returns the complete upload path for storing uploaded files.
     *
     * @param string $append
     *
     * @return string
     */
    public function getUploadPath($append = null)
    {
        $path = $this->appendPath($this->baseDir, $append);

        return $path;
    }

    /**
     * Returns a unique file name for the specified file.
     *
     * @param UploadedFile $file
     *
     * @return string
     */
    public function getUniqueFileName(UploadedFile $file)
    {
        return uniqid($this->getUploadTimestamp()) . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Returns the uploaded timestamp string to
     * be appended onto the uploaded file name.
     *
     * @return bool|string
     */
    public function getUploadTimestamp()
    {
        return date($this->timestampFormat);
    }

    /**
     * Appends the specified argument onto the specified path.
     *
     * @param string $path
     * @param string $append
     *
     * @return string
     */
    protected function appendPath($path, $append = null)
    {
        if($append) {
            return (string) $path . DIRECTORY_SEPARATOR . (string) $append;
        }

        return $path;
    }
}
