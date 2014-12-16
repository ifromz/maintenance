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
    
    public function getApiEvents()
    {
        $events = $this->eventApiService->setInput($this->input)->get();
        
        return $events;
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
     * Returns recurrences from the specified API ID
     * 
     * @param string $api_id
     * @return object
     */
    public function getRecurrencesByApiId($api_id)
    {
        $recurrences = $this->eventApiService->setInput($this->input)->getRecurrences($api_id);
        
        return $recurrences;
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
     * @return \Stevebauman\CalendarHelper\Objects\Event
     */
    public function updateByApiId($api_id)
    {
        return $this->eventApiService->setInput($this->input)->update($api_id);
    }
    
    /**
     * Updates the specified event dates
     * 
     * @param string $api_id
     * @return \Stevebauman\CalendarHelper\Objects\Event
     */
    public function updateDates($api_id)
    {
        return $this->eventApiService->setInput($this->input)->updateDates($api_id);
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
    
    /**
     * Parses a google collection of events into an array of events compatible
     * with FullCalendar
     * 
     * @param collection $events
     * @return type
     */
    public function parseEvents($events)
    {   
        $arrayEvents = array();
        
        foreach($events as $event) {
            
            $startDate = new \DateTime($event->start);
            $endDate = new \DateTime($event->end);
            
            if($event->all_day) {
                
                /*
                 * Subtract one day fix for FullCalendar
                 */
                $endDate->sub(new \DateInterval('P1D'));
                
            }
            
            /*
             * Add the event into a FullCalendar compatible array
             */
            $arrayEvents[] = array(
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->location,
                'start' => $startDate->format('Y-m-d H:i:s'),
                'end' => $endDate->format('Y-m-d H:i:s'),
                'allDay' => $event->all_day,
            );
        }
        
        return $arrayEvents;
    }
    
}