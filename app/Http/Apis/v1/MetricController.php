<?php

namespace App\Http\Apis\v1;

use App\Models\Metric;
use App\Repositories\MetricRepository;

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
     * Returns a new metric grid.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'name',
            'symbol',
            'created_at',
            'user_id',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle'  => 11,
        ];

        $transformer = function (Metric $metric) {
            return [
                'id'         => $metric->id,
                'name'       => $metric->name,
                'symbol'     => $metric->symbol,
                'created_at' => $metric->created_at,
                'created_by' => ($metric->user ? $metric->user->full_name : 'None'),
                'view_url'   => route('maintenance.metrics.show', [$metric->id]),
            ];
        };

        return $this->metric->grid($columns, $settings, $transformer);
    }
}
