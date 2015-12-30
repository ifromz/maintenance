<?php

namespace Stevebauman\Maintenance\Services\Event;

use Stevebauman\Maintenance\Models\EventReport;
use Stevebauman\Maintenance\Services\BaseModelService;
use Stevebauman\Maintenance\Services\SentryService;

class ReportService extends BaseModelService
{
    /**
     * @var EventReport
     */
    protected $model;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param EventReport   $report
     * @param SentryService $sentry
     */
    public function __construct(EventReport $report, SentryService $sentry)
    {
        $this->model = $report;
        $this->sentry = $sentry;
    }

    /**
     * Creates an event report.
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'user_id'     => $this->sentry->getCurrentUserId(),
                'event_id'    => $this->getInput('event_id'),
                'description' => $this->getInput('description', null, true),
            ];

            $record = $this->model->create($insert);

            if ($record) {
                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
