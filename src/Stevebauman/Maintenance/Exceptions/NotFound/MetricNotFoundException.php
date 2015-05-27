<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound;

use Stevebauman\Maintenance\Exceptions\BaseException;

class MetricNotFoundException extends BaseException
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Metric']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.metrics.index');
    }
}
