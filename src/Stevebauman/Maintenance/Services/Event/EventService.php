<?php

namespace Stevebauman\Maintenance\Services\Event;

use Stevebauman\Maintenance\Exceptions\EventNotFoundException;
use Stevebauman\Maintenance\Services\Google\EventService as GoogleEventService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Event;
use Stevebauman\Maintenance\Services\BaseModelService;

/**
 * Handles interactions between the Event Model and the Event Api Service
 */
class EventService extends BaseModelService {
    
    public function __construct(
            Event $model,
            GoogleEventService $google, 
            SentryService $sentry,
            EventNotFoundException $notFoundException)
    {
        $this->model = $model;
        $this->eventApiService = $google;
        $this->sentry = $sentry;
        
        $this->notFoundException = $notFoundException;
    }
    
    public function get($select = array())
    {
        $records = $this->model->where('parent_id', NULL)->get();
        
        $events = $this->eventApiService->getOnly($records->lists('api_id'));
        
        return $events;
    }
    
    /**
     * Returns a collection of all API events
     * 
     * @param array $apiIds
     * @return collection
     */
    public function getApiEvents($apiIds = array(), $recurrences = false)
    {
        if(count($apiIds) > 0) {
            
            $events = $this->eventApiService->setInput($this->input)->getOnly($apiIds, $recurrences);
            
        } else {
            $events = $this->eventApiService->setInput($this->input)->get();
        }
        
        return $events;
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
     * Retrieves and returns an API event by it's API ID
     * 
     * @param string $api_id
     * @return object
     * @throws EventNotFoundException
     */
    public function findByApiId($api_id)
    {
        $event = $this->eventApiService->find($api_id);
        
        if($event) {
            
            /*
             * If the event is a recurrence, we need to create a local
             * record of it so we can attach reports to it.
             */
            if($event->isRecurrence) {
                
                $this->createRecurrence($event);
                
            }
            
            return $event;
        } else {
            throw new $this->notFoundException;
        }
        
    }
    
    /**
     * Retrieves the local database record of the API event
     * 
     * @param string $api_id
     * @return object
     * @throws EventNotFoundException
     */
    public function findLocalByApiId($api_id)
    {
        $event = $this->model
                ->where('api_id', $api_id)
                ->with('assets', 'inventories', 'workOrders')
                ->first();
        
        if($event) {
            return $event;
        } else {
            throw new $this->notFoundException;
        }
        
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
        
        /*
         * If the event was created successfully, we now have to attach the specified
         * assets / inventories / work orders to the event
         */
        if($event) {
            
            /*
             * Create the main event
             */
            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'api_id' => $event->id,
            );
        
            $record = $this->model->create($insert);
            
            /*
             * Attach the assets / inventories / work orders if they are present
             */
            $assets = $this->getInput('assets');
            $inventories = $this->getInput('inventories');
            $workOrders = $this->getInput('work_orders');
            
            if($assets) {
                $record->assets()->attach($this->getInput('assets'));
            }
            
            if($inventories) {
                $record->inventories()->attach($this->getInput('inventories'));
            }
            
            if($workOrders) {
                $record->workOrders()->attach($this->getInput('work_orders'));
            }
            
            return $event;
            
        }
        
        return false;
    }
    
    /**
     * Creates a local recurrence from the specified parent event
     */
    public function createRecurrence($event)
    {
        $this->dbStartTransaction();
            
        /*
         * If the API event exists, make sure it exists in the
         * local database, and the same user ID is used. This is used for
         * making reports on recuring events
         */
        $record = $this->where('api_id', $event->parent_id)->first();

        $insert = array(
            'api_id' => $event->id,
            'parent_id' => $record->id,
            'user_id' => $record->user_id,
        );
        
        /*
         * Use first or create so we don't create duplicate local recurrence
         * records
         */
        $recurrence = $this->model->firstOrCreate($insert);
        
        if($recurrence) {
            $this->dbCommitTransaction();
            
            return $recurrence;
        }
        
        $this->dbRollbackTransaction();
            
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