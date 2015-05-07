<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Attachment;

class AttachmentService extends BaseModelService
{
    /**
     * @param Attachment $attachment
     */
    public function __construct(Attachment $attachment)
    {
        $this->model = $attachment;
    }

    /**
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $record = $this->model->create($this->input);

            $this->dbCommitTransaction();

            return $record;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }
}
