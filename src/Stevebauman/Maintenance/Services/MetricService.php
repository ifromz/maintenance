<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\MetricNotFoundException;
use Stevebauman\Maintenance\Models\Metric;

/**
 * Class MetricService
 * @package Stevebauman\Maintenance\Services
 */
class MetricService extends BaseModelService
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param Metric $metric
     * @param SentryService $sentry
     * @param MetricNotFoundException $notFoundException
     */
    public function __construct(Metric $metric, SentryService $sentry, MetricNotFoundException $notFoundException)
    {
        $this->model = $metric;
        $this->sentry = $sentry;
        $this->notFoundException = $notFoundException;
    }

    /**
     * Retrieves all metrics
     *
     * @param array $select
     * @return mixed
     */
    public function get($select = array())
    {
        return $this->model->sort($this->getInput('field'), $this->getInput('sort'))->get();
    }

    /**
     * Processes creating a metric
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try
        {
            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'name' => $this->getInput('name'),
                'symbol' => $this->getInput('symbol')
            );

            $record = $this->model->create($insert);

            $this->dbCommitTransaction();

            return $record;

        } catch (\Exception $e)
        {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Processes updating the specified metric
     *
     * @param int|string $id
     * @return bool|mixed
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try
        {
            $insert = array(
                'name' => $this->getInput('name'),
                'symbol' => $this->getInput('symbol')
            );

            $record = $this->find($id);

            if ($record->update($insert))
            {
                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e)
        {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}