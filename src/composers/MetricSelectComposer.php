<?php 

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\MetricService;

/*
 * Passes all the metrics available to be selected to the metric select box
 */
class MetricSelectComposer {
    
    public function __construct(MetricService $metric)
    { 
        $this->metric = $metric;
    }
    
    public function compose($view){
       $allMetrics = $this->metric->get()->lists('name', 'id');
       
       $allMetrics['0'] = 'Select a Metric';
       
       return $view->with('allMetrics', $allMetrics);
        
    }
    
}
