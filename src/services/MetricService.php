<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\MetricNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Metric;
use Stevebauman\Maintenance\Services\AbstractModelService;

class MetricService extends AbstractModelService {
    
    public function __construct(Metric $metric, SentryService $sentry, MetricNotFoundException $notFoundException)
    {
        $this->model = $metric;
        $this->sentry = $sentry;
        $this->notFoundException = $notFoundException;
    }
    
    public function create()
    {
        $insert = array(
            'user_id' => $this->sentry->getCurrentUserId(),
            'name' => $this->getInput('name'),
            'symbol' => $this->getInput('symbol')
        );
        
        if($record = $this->model->create($insert)){
            return $record;
        } else{
            return false;
        }
    }
    
    public function update($id)
    {
        $insert = array(
            'name' => $this->getInput('name'),
            'symbol' => $this->getInput('symbol')
        );
        
        $record = $this->find($id);
        
        if($record->update($insert)){
            return $record;
        } else{
            return false;
        }
    }
    
}