<?php

namespace Stevebauman\Maintenance\Repositories;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Filesystem\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Stevebauman\Maintenance\Http\Requests\AttachmentUpdateRequest;
use Stevebauman\Maintenance\Http\Requests\AttachmentRequest;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Attachment;

class AttachmentRepository extends Repository
{
    /**
     * The directory to store the uploaded files in.
     *
     * @var string
     */
    protected $uploadDir = '';

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
     * Constructor.
     *
     * @param SentryService $sentry
     * @param Factory       $storage
     */
    public function __construct(SentryService $sentry, Factory $storage)
    {
        $this->sentry = $sentry;
        $this->storage = $storage->disk($this->model()->getDisk());
    }

    /**
     * @return Attachment
     */
    public function model()
    {
        return new Attachment();
    }

    /**
     * Uploads the request files for the specified work order.
     *
     * @param AttachmentRequest $request
     * @param Model             $model
     * @param BelongsToMany     $relation
     *
     * @return array
     */
    public function upload(AttachmentRequest $request, Model $model, BelongsToMany $relation)
    {
        $uploads = [];

        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                if($file instanceof UploadedFile) {
                    $upload = $this->create($model, $file, $relation);

                    if($upload) {
                        $uploads[] = $upload;
                    }
                }
            }
        }

        if(count($uploads) > 0) {
            return $uploads;
        }

        return false;
    }

    /**
     * Creates an upload record for the specified work order and uploaded file.
     *
     * @param Model         $model
     * @param UploadedFile  $file
     * @param BelongsToMany $relation
     *
     * @return \Stevebauman\Maintenance\Models\Attachment|bool
     */
    public function create(Model $model, UploadedFile $file, BelongsToMany $relation)
    {
        $path = $this->getUploadPath($model->getKey());

        $fileName = $this->getUniqueFileName($file);

        $storePath = $path.DIRECTORY_SEPARATOR.$fileName;

        $realPath = $file->getRealPath();

        $contents = ($realPath ? file_get_contents($realPath) : false);

        if($contents && $this->storage->put($storePath, $contents)) {
            $attributes = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'name' => $file->getClientOriginalName(),
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $storePath,
            ];

            $attachment = $relation->create($attributes);

            if($attachment) {
                return $attachment;
            }
        }

        return false;
    }

    /**
     * Updates an upload record for the specified work order.
     *
     * @param AttachmentUpdateRequest $request
     * @param BelongsToMany           $relation
     * @param int|string              $id
     *
     * @return \Stevebauman\Maintenance\Models\Attachment|bool
     */
    public function update(AttachmentUpdateRequest $request, BelongsToMany $relation, $id)
    {
        $attachment = $relation->find($id);

        if($attachment) {
            $attachment->name = $request->input('name', $attachment->name);

            if($attachment->save()) {
                return $attachment;
            }
        }

        return false;
    }

    /**
     * Returns the complete upload path.
     *
     * @param string $append
     *
     * @return string
     */
    public function getUploadPath($append = null)
    {
        $path = $this->appendPath($this->uploadDir, $append);

        return $this->getBaseUploadPath($path);
    }

    /**
     * Returns the complete upload path for storing uploaded files.
     *
     * @param string $append
     *
     * @return string
     */
    public function getBaseUploadPath($append = null)
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
