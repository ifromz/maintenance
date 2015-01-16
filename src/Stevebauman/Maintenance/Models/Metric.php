<?php

namespace Stevebauman\Maintenance\Models;

/**
 * Class Metric
 * @package Stevebauman\Maintenance\Models\Extended
 */
class Metric extends BaseModel
{

    protected $table = 'metrics';

    protected $fillable = array(
        'name',
        'symbol'
    );

    protected $viewer = 'Stevebauman\Maintenance\Viewers\MetricViewer';

}