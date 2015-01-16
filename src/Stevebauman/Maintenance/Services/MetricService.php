<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\MetricNotFoundException;
use Stevebauman\Maintenance\Models\Metric;

class MetricService extends BaseModelService
{

    public function __construct(Metric $metric, SentryService $sentry, MetricNotFoundException $notFoundException)
    {
        $this->model = $metric;
        $this->sentry = $sentry;
        $this->notFoundException = $notFoundException;
    }

    public function get($select = array())
    {
        return $this->model->sort($this->getInput('field'), $this->getInput('sort'))->get();
    }

    public function create()
    {
        $this->dbStartTransaction();

        try {

            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'name' => $this->getInput('name'),
                'symbol' => $this->getInput('symbol')
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

            $insert = array(
                'name' => $this->getInput('name'),
                'symbol' => $this->getInput('symbol')
            );

            $record = $this->find($id);

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