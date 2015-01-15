<?php

namespace Stevebauman\Maintenance\Models\Extended;

use Venturecraft\Revisionable\RevisionableTrait;
use Stevebauman\Inventory\Models\Metric as BaseMetric;

/**
 * Class Metric
 * @package Stevebauman\Maintenance\Models\Extended
 */
class Metric extends BaseMetric
{

    use RevisionableTrait;

    protected $viewer = 'Stevebauman\Maintenance\Viewers\MetricViewer';

}