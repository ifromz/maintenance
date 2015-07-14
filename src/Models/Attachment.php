<?php

namespace Stevebauman\Maintenance\Models;

use Illuminate\Support\Facades\Storage;
use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;
use Stevebauman\Maintenance\Viewers\AttachmentViewer;

class Attachment extends Model
{
    use HasUserTrait;

    /**
     * The attachments table.
     *
     * @var string
     */
    protected $table = 'attachments';

    /**
     * The storage disk.
     *
     * @var string
     */
    protected $disk = 'local';

    /**
     * The attachments viewer.
     *
     * @var string
     */
    protected $viewer = AttachmentViewer::class;

    /**
     * The fillable attachment attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'file_name',
        'file_path',
    ];

    /**
     * Returns the disk to store files on.
     *
     * @return string
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * Returns the full path of the uploaded file.
     *
     * @return string
     */
    public function getFullPathAttribute()
    {
        $config = sprintf('filesystems.%s.root', $this->getDisk());

        $default = storage_path('app');

        $basePath = config($config, $default);

        return $basePath . DIRECTORY_SEPARATOR . $this->file_path;
    }

    /**
     * Returns the complete download path for the uploaded file.
     *
     * @return string
     */
    public function getDownloadPathAttribute()
    {
        return $this->getFullPathAttribute();
    }

    /**
     * Returns the last modified date of the uploaded file.
     *
     * @return string
     */
    public function getLastModifiedAttribute()
    {
        return Storage::disk($this->getDisk())->lastModified($this->file_path);
    }

    /**
     * Returns the size in bytes of the uploaded file.
     *
     * @return string
     */
    public function getSizeAttribute()
    {
        return Storage::disk($this->getDisk())->size($this->file_path);
    }

    /**
     * Returns the extension of the uploaded file.
     *
     * @return string
     */
    public function getMimeTypeAttribute()
    {
        return Storage::disk($this->getDisk())->getMimetype($this->file_path);
    }

    /**
     * Returns a large icon representing the uploaded file type.
     *
     * @return string
     */
    public function getIconAttribute()
    {
        $mime = $this->getMimeTypeAttribute();

        return view('maintenance::partials.models.attachment.icon', compact('mime'))->render();
    }
}
