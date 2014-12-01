<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Priority;
use Stevebauman\Maintenance\Services\BaseModelService;

class PriorityService extends BaseModelService {
    
    public function __construct(Priority $priority, SentryService $sentry)
    {
        $this->model = $priority;
        $this->sentry = $sentry;
    }
    
    public function create()
    {
        $this->dbStartTransaction();
        
        try {
            
            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'name' => $this->getInput('name'),
                'color' => $this->getInput('color')
            );
            
            $record = $this->model->create($insert);
            
            $this->dbCommitTransaction();
            
            return $record;
            
        } catch (Exception $e) {
            
            $this->dbRollbackTransaction();
            
            return false;
        }
        
     
    }
    
    public function update($id)
    {
        
        $this->dbStartTransaction();
        
        try {
            
            $record = $this->find($id);
            
            $insert = array(
                'name' => $this->getInput('name'),
                'color' => $this->getInput('color')
            );
            
            if($record->update($insert)) {
                
                $this->dbCommitTransaction();
                
                return true;
            }
            
            $this->dbRollbackTransaction();
            
            return false;
        
        } catch (Exception $e) {
            
            $this->dbRollbackTransaction();
            
            return false;
        }
        
    }
    
    public function firstOrCreateRequest()
    {
        $this->dbStartTransaction();
        
        try {
            
            $insert = array(
                'name' => 'Requested',
                'color' => 'default'
            );
            
            $record = $this->model->firstOrCreate($insert);
            
            $this->dbCommitTransaction();
            
            return $record;
        
        } catch (Exception $e) {
            
            $this->dbRollbackTransaction();
            
            return false;
        }
    }
    
    
}