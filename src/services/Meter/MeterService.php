<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Meter;
use Stevebauman\Maintenance\Services\AbstractModelService;

class MeterService extends AbstractModelService {
    
    public function __construct(Meter $meter, SentryService $sentry)
    {
        $this->model = $meter;
        $this->sentry = $sentry;
    }
    
    public function create()
    {
        $insert = array(
            'user_id' => $this->sentry->getCurrentUserId(),
            'metric_id' => $this->getInput('metric'),
            'name' => $this->getInput('name')
        );
        
        return $this->model->create($insert);
    }
    
    public function update($id)
    {
        $record = $this->find($id);
        
        $insert = array(
            'metric_id' => $this->getInput('metric'),
            'name' => $this->getInput('name')
        );
        
        if($record->update($insert)){
            return $record;
        } else{
            return false;
        }
    }
    
}