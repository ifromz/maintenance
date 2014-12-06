<?php

namespace Stevebauman\Maintenance\Services\Event;

use Stevebauman\Maintenance\Services\Google\EventService as GoogleEventService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Event;
use Stevebauman\Maintenance\Services\BaseModelService;

class EventService extends BaseModelService {
    
    public function __construct(Event $model, GoogleEventService $google, SentryService $sentry)
    {
        $this->model = $model;
        $this->google = $google;
        $this->sentry = $sentry;
    }
    
    /**
     * Creates a google event and then creates a local database record
     * attaching it to whatever created it along with inserting
     * the google event ID
     * 
     * @return mixed (boolean OR object)
     */
    public function create()
    {
        /*
         * Pass the input along to the google event service and create google
         * event
         */
        $googleEvent = $this->google->setInput($this->input)->create();
        
        if($googleEvent) {
            
            $this->dbStartTransaction();
            
            $insert = array(
                'eventable_id' => $this->getInput('object')->id,
                'eventable_type' => get_class($this->getInput('object')),
                'user_id' => $this->sentry->getCurrentUserId(),
                'api_id' => $googleEvent->getId(),
            );
            
            $record = $this->model->create($insert);
            
            if($record) {
                
                $this->dbCommitTransaction();
                
                return $record;
            }
            
            $this->dbRollbackTransaction();
            
        }
        
        return false;
    }
    
    public function update($id)
    {
        
    }
    
    public function destroy($id)
    {
        
    }
    
}