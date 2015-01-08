<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\MetricValidator;
use Stevebauman\Maintenance\Services\MetricService;
use Stevebauman\Maintenance\Controllers\BaseController;

class MetricController extends BaseController {
    
    public function __construct(MetricService $metric, MetricValidator $metricValidator)
    {
        $this->metric = $metric;
        $this->metricValidator = $metricValidator;
    }
    
    public function index()
    {
        $metrics = $this->metric->setInput($this->inputAll())->get();
        
        return view('maintenance::metrics.index', array(
            'title' => 'All Metrics',
            'metrics' => $metrics
        ));
    }
    
    public function create()
    {
        return view('maintenance::metrics.create', array(
            'title' => 'Create a Metric',
        ));
    }
    
    public function store()
    {
        if($this->metricValidator->passes()) {
            
            $metric = $this->metric->setInput($this->inputAll())->create();
            
            $this->message = 'Successfully created metric.';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.metrics.index');
            
        } else {
            $this->errors = $this->metricValidator->getErrors();
            $this->redirect = route('maintenance.metrics.create');
        }
        
        return $this->response();
    }
    
    public function edit($id)
    {
        $metric = $this->metric->find($id);
        
        return view('maintenance::metrics.edit', array(
            'title' => 'Edit Metric: '.$metric->name,
            'metric' => $metric
        ));
    }
    
    public function update($id)
    {
        if($this->metricValidator->passes()) {
            
            $metric = $this->metric->setInput($this->inputAll())->update($id);
            
            $this->message = 'Successfully updated metric.';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.metrics.index');
            
        } else {
            $this->errors = $this->metricValidator->getErrors();
            $this->redirect = route('maintenance.metrics.edit');
        }
        
        return $this->response();
    }
    
    public function destroy($id)
    {
        $this->metric->destroy($id);
        
        $this->message = 'Successfully deleted metric';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.metrics.index');
        
        return $this->response();
    }
    
}