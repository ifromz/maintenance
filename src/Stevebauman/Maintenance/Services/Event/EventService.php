<?php

namespace Stevebauman\Maintenance\Services\Event;

use Stevebauman\Maintenance\Services\Google\EventService as GoogleEventService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Event;
use Stevebauman\Maintenance\Services\BaseModelService;

/**
 * Handles interactions between the Event Model and the Event Api Service
 */
class EventService extends BaseModelService {
    
    public function __construct(Event $model, GoogleEventService $google, SentryService $sentry)
    {
        $this->model = $model;
        $this->eventApiService = $google;
        $this->sentry = $sentry;
    }
    
    /**
     * Finds and returns an event by it's API ID
     * 
     * @param string $api_id
     * @return object
     */
    public function findByApiId($api_id)
    {
        $entry = $this->eventApiService->find($api_id);
        
        return $entry;
    }
    
    /**
     * Retrieves events attached to the specified object
     * 
     * @param object $object
     * @return object
     */
    public function getFromObject($object)
    {
        /*
         * Grab our local records of the event
         */
        $records = $this->model
                ->where('eventable_type', get_class($object))
                ->where('eventable_id', $object->id)
                ->get();
        
        /*
         * Grab the service records
         */
        $events = $this->eventApiService->getOnly($records->lists('api_id'));
        
        /*
         * Removed deleted events from the local database
         */
        $this->sync($events);
        
        return $events;
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
        $event = $this->eventApiService->setInput($this->input)->create();
        
        if($event) {
            
            $this->dbStartTransaction();
            
            $eventableObject = $this->getInput('object');
            
            $insert = array(
                'eventable_id' => $eventableObject->id,
                'eventable_type' => get_class($eventableObject),
                'user_id' => $this->sentry->getCurrentUserId(),
                'api_id' => $event->id,
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
    
    /**
     * Updates an event by the specified API ID
     * 
     * @param string $api_id
     * @return type
     */
    public function updateByApiId($api_id)
    {
        return $this->eventApiService->setInput($this->input)->update($api_id);
    }
    
    /**
     * Removes event from the local database calendar and then removes it from
     * the API calendar
     * 
     * @param string $api_id
     * @return boolean
     */
    public function destroyByApiId($api_id)
    {
        $this->model->where('api_id', $api_id)->delete();
        
        return $this->eventApiService->destroy($api_id);
    }
    
    /**
     * Removes local events from the database if the status is cancelled
     * 
     * @param array $events
     * @return void
     */
    public function sync($events)
    {
        foreach($events as $event) {
            
            if($event->status === 'cancelled') {
                
                $this->model->where('api_id', $event->id)->delete();
                
            }
            
        }
    }
    
}