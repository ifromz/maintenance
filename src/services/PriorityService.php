<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Priority;
use Stevebauman\Maintenance\Services\AbstractModelService;

class PriorityService extends AbstractModelService {
    
    public function __construct(Priority $priority, SentryService $sentry)
    {
        $this->model = $priority;
        $this->sentry = $sentry;
    }
    
    public function create()
    {
        $insert = array(
            'user_id' => $this->sentry->getCurrentUserId(),
            'name' => $this->getInput('name'),
            'color' => $this->getInput('color')
        );
        
        return $this->model->create($insert);
    }
    
    public function update($id)
    {
        $insert = array(
            'name' => $this->getInput('name'),
            'color' => $this->getInput('color')
        );
        
        $record = $this->find($id);
        
        return $record->update($insert);
        
    }
    
    public function firstOrCreateRequest()
    {
        $insert = array(
            'name' => 'Requested',
            'color' => 'default'
        );
        
        return $this->model->firstOrCreate($insert);
    }
    
    
}