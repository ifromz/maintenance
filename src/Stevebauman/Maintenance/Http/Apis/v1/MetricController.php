<?php

namespace Stevebauman\Maintenance\Http\Apis\v1;

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
        ];

        $transformer = function($element)
        {
            return [
                'id' => $element->id,
                'name' => $element->name,
                'symbol' => $element->symbol,
                'created_at' => $element->created_at,
                'created_by' => ($element->user ? $element->user->full_name : 'None'),
                'view_url' => route('maintenance.metrics.show', [$element->id]),
            ];
        };

        return $this->metric->grid($columns, $settings, $transformer);
    }
}
