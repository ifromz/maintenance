<?php

namespace Stevebauman\Maintenance\Models;

/**
 * Class Metric
 *
 * @package Stevebauman\Maintenance\Models
 */
class Metric extends BaseModel
{
    protected $table = 'metrics';

    protected $fillable = [
        'name',
        'symbol'
    ];

    protected $viewer = 'Stevebauman\Maintenance\Viewers\MetricViewer';
}
