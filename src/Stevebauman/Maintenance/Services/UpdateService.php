<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Update;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\BaseModelService;

class UpdateService extends BaseModelService
{

    public function __construct(Update $update, SentryService $sentry)
    {
        $this->model = $update;
        $this->sentry = $sentry;
    }

    public function create()
    {
        $this->dbStartTransaction();

        try {

            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'content' => $this->getInput('update_content', NULL, true)
            );

            $record = $this->model->create($insert);

            $this->dbCommitTransaction();

            return $record;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }
}