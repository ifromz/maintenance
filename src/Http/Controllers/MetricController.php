<?php

namespace Stevebauman\Maintenance\Http\Controllers;

use Stevebauman\Maintenance\Http\Requests\MetricRequest;
use Stevebauman\Maintenance\Repositories\MetricRepository;

class MetricController extends Controller
{
    /**
     * @var MetricRepository
     */
    protected $metric;

    /**
     * @param MetricRepository $metric
     */
    public function __construct(MetricRepository $metric)
    {
        $this->metric = $metric;
    }

    /**
     * Displays all metrics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance::metrics.index');
    }

    /**
     * Displays the form to create a metric.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('maintenance::metrics.create');
    }

    /**
     * Creates a metric.
     *
     * @param MetricRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(MetricRequest $request)
    {
        $metric = $this->metric->create($request);

        if($metric) {
            $message = 'Successfully created metric.';

            return redirect()->route('maintenance.metrics.index')->withSuccess($message);
        } else {
            $message = 'There was an issue creating this metric. Please try again.';

            return redirect()->route('maintenance.metrics.index')->withErrors($message);
        }
    }

    /**
     * Displays information about the metric.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $metric = $this->metric->model()->findOrFail($id);

        return view('maintenance::metrics.show', compact('metric'));
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
        $metric = $this->metric->model()->findOrFailfind($id);

        return view('maintenance::metrics.edit', compact('metric'));
    }

    /**
     * Updates the specified metric.
     *
     * @param MetricRequest $request
     * @param int|string    $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(MetricRequest $request, $id)
    {
        $metric = $this->metric->update($request, $id);

        if($metric) {
            $message = 'Successfully updated metric.';

            return redirect()->route('maintenance.metrics.index')->withSuccess($message);
        } else {
            $message = 'There was an issue updating this metric. Please try again.';

            return redirect()->route('maintenance.metrics.edit', [$id])->withSuccess($message);
        }
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
        $metric = $this->metric->model()->findOrFail($id);

        if($metric->delete()) {
            $message = 'Successfully deleted metric.';

            return redirect()->route('maintenance.metrics.index')->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this metric. Please try again.';

            return redirect()->route('maintenance.metrics.edit', [$id])->withSuccess($message);
        }
    }
}
