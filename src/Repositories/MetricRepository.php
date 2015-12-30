<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Http\Requests\MetricRequest;
use Stevebauman\Maintenance\Models\Metric;
use Stevebauman\Maintenance\Services\SentryService;

class MetricRepository extends Repository
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param SentryService $sentry
     */
    public function __construct(SentryService $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * @return Metric
     */
    public function model()
    {
        return new Metric();
    }

    /**
     * Creates a new metric.
     *
     * @param MetricRequest $request
     *
     * @return bool|Metric
     */
    public function create(MetricRequest $request)
    {
        $metric = $this->model();

        $metric->name = $request->input('name');
        $metric->symbol = $request->input('symbol');
        $metric->user_id = $this->sentry->getCurrentUserId();

        if ($metric->save()) {
            return $metric;
        }

        return false;
    }

    /**
     * Updates a metric.
     *
     * @param MetricRequest $request
     * @param int|string    $id
     *
     * @return bool|Metric
     */
    public function update(MetricRequest $request, $id)
    {
        $metric = $this->model()->findOrFail($id);

        if ($metric) {
            $metric->name = $request->input('name', $metric->name);
            $metric->symbol = $request->input('symbol', $metric->symbol);

            if ($metric->save()) {
                return $metric;
            }
        }

        return false;
    }
}
