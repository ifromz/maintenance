<?php

namespace Stevebauman\Maintenance\Services\Event;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\EventReport;
use Stevebauman\Maintenance\Services\BaseModelService;

class ReportService extends BaseModelService
{

    public function __construct(EventReport $report, SentryService $sentry)
    {
        $this->model = $report;
        $this->sentry = $sentry;
    }

    public function create()
    {
        $this->dbStartTransaction();

        $insert = array(
            'user_id' => $this->sentry->getCurrentUserId(),
            'event_id' => $this->getInput('event_id'),
            'description' => $this->getInput('description', NULL, true),
        );

        $record = $this->model->create($insert);

        if ($record) {

            $this->dbCommitTransaction();

            return $record;

        }

        $this->dbRollbackTransaction();

        return false;
    }

}