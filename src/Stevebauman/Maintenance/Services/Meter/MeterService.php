<?php

namespace Stevebauman\Maintenance\Services\Meter;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Meter;
use Stevebauman\Maintenance\Services\BaseModelService;

class MeterService extends BaseModelService
{

    public function __construct(Meter $meter, SentryService $sentry)
    {
        $this->model = $meter;
        $this->sentry = $sentry;
    }

    public function create()
    {
        $this->dbStartTransaction();

        try {

            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'metric_id' => $this->getInput('metric'),
                'name' => $this->getInput('name')
            );

            $record = $this->model->create($insert);

            $this->dbCommitTransaction();

            return $record;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

    public function update($id)
    {
        $this->dbStartTransaction();

        try {

            $record = $this->find($id);

            $insert = array(
                'metric_id' => $this->getInput('metric'),
                'name' => $this->getInput('name')
            );

            if ($record->update($insert)) {
                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            return false;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

}