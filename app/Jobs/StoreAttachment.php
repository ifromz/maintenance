<?php

namespace App\Jobs;

use App\Http\Requests\AttachmentRequest;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StoreAttachment extends Job
{
    /**
     * @var AttachmentRequest
     */
    protected $request;

    /**
     * @var BelongsToMany
     */
    protected $relation;

    /**
     * The storage path to upload files to.
     *
     * @var string
     */
    protected $path = 'files';

    /**
     * Constructor.
     *
     * @param AttachmentRequest $request
     * @param BelongsToMany $relation
     */
    public function __construct(AttachmentRequest $request, BelongsToMany $relation)
    {
        $this->request = $request;
        $this->relation = $relation;
    }

    public function handle(Filesystem $filesystem)
    {
        $files = $this->request->file('files');

        if (is_array($files)) {
            foreach ($files as $file) {
                // Double check that we have an uploaded file instance.
                if ($file instanceof UploadedFile) {
                    $path = storage_path($this->path);

                    //
                }
            }
        }

        return false;
    }
}
