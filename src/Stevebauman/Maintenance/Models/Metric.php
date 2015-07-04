<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Viewers\MetricViewer;

class Metric extends BaseModel
{
    /**
     * The metrics table.
     *
     * @var string
     */
    protected $table = 'metrics';

    /**
     * The fillable metric attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'symbol',
    ];

    /**
     * The metric viewer class.
     *
     * @var string
     */
    protected $viewer = MetricViewer::class;
}
