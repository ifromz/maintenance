<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Update;

/**
 * Class UpdateService
 * @package Stevebauman\Maintenance\Services
 */
class UpdateService extends BaseModelService
{
    /**
     * Constructor.
     *
     * @param Update $update
     * @param SentryService $sentry
     */
    public function __construct(Update $update, SentryService $sentry)
    {
        $this->model = $update;
        $this->sentry = $sentry;
    }

    /**
     * Creates an update.
     *
     * @return bool|Update
     */
    public function create()
    {
        $this->dbStartTransaction();

        try
        {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'content' => $this->getInput('update_content', null, true)
            ];

            $record = $this->model->create($insert);

            $this->dbCommitTransaction();

            return $record;
        } catch (\Exception $e)
        {
            $this->dbRollbackTransaction();

            return false;
        }
    }
}
