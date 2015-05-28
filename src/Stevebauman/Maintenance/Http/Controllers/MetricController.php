<?php

namespace Stevebauman\Maintenance\Http\Controllers;

use Stevebauman\Maintenance\Validators\MetricValidator;
use Stevebauman\Maintenance\Services\MetricService;

/**
 * Class MetricController
 */
class MetricController extends BaseController
{
    /**
     * Constructor.
     *
     * @param MetricService $metric
     * @param MetricValidator $metricValidator
     */
    public function __construct(MetricService $metric, MetricValidator $metricValidator)
    {
        $this->metric = $metric;
        $this->metricValidator = $metricValidator;
    }

    /**
     * Displays all metrics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $metrics = $this->metric->setInput($this->inputAll())->get();

        return view('maintenance::metrics.index', [
            'title' => 'All Metrics',
            'metrics' => $metrics,
        ]);
    }

    /**
     * Displays the form to create a metric.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('maintenance::metrics.create', [
            'title' => 'Create a Metric',
        ]);
    }

    /**
     * Creates a metric.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->metricValidator->unique('name', $this->metric->getTableName(), 'name');
        $this->metricValidator->unique('symbol', $this->metric->getTableName(), 'symbol');

        if ($this->metricValidator->passes()) {
            $this->metric->setInput($this->inputAll())->create();

            $this->message = 'Successfully created metric.';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.metrics.index');
        } else {
            $this->errors = $this->metricValidator->getErrors();
            $this->redirect = route('maintenance.metrics.create');
        }

        return $this->response();
    }

    /**
     * Displays the form for editing the specified metric.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $metric = $this->metric->find($id);

        return view('maintenance::metrics.edit', [
            'title' => 'Edit Metric: '.$metric->name,
            'metric' => $metric,
        ]);
    }

    /**
     * Updates the specified metric.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $this->metricValidator->ignore('name', $this->metric->getTableName(), 'name', $id);

        if ($this->metricValidator->passes()) {
            $this->metric->setInput($this->inputAll())->update($id);

            $this->message = 'Successfully updated metric.';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.metrics.index');
        } else {
            $this->errors = $this->metricValidator->getErrors();
            $this->redirect = route('maintenance.metrics.edit');
        }

        return $this->response();
    }

    /**
     * Updates the specified metric.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->metric->destroy($id);

        $this->message = 'Successfully deleted metric';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.metrics.index');

        return $this->response();
    }
}
