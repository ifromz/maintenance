<?php

namespace Stevebauman\Maintenance\Controllers\Event;

use Stevebauman\Maintenance\Validators\EventValidator;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Controllers\BaseController;

class BaseEventController extends BaseController {
    
    /*
     * Stores the eventable service to save the event on
     */
    protected $eventable;
    
    /*
     * Stores the name of the eventable service to display on views
     */
    protected $eventableName;
    
    /*
     * Stores the property field name to get the objects name / title for displaying
     * on views
     */
    protected $eventableNameField;
    
    public function __construct(EventService $event, EventValidator $eventValidator)
    {
        $this->event = $event;
        $this->eventValidator = $eventValidator;
    }
    
    /**
     * Displays the index of all the events on the eventable object
     * 
     * @param string $eventable_id
     * @return view
     */
    public function index($eventable_id)
    {
        $eventable = $this->eventable->find($eventable_id);
        
        $events = $this->event->getFromObject($eventable);

        return view('maintenance::events.index', array(
            'title' => sprintf('Viewing events for %s: %s', $this->eventableName, $eventable->{$this->eventableNameField}),
            'eventable' => $eventable,
            'events' => $events
        ));
    }
    
    /**
     * Displays the form for creating a new event on the eventable object
     * 
     * @param string $eventable_id
     * @return view
     */
    public function create($eventable_id)
    {
        $eventable = $this->eventable->find($eventable_id);
        
        return view('maintenance::events.create', array(
            'title' => sprintf('Creating event for %s: %s', $this->eventableName, $eventable->{$this->eventableNameField}),
            'eventable' => $eventable
        ));
    }
    
    /**
     * Stores a new event on the eventable object
     * 
     * @param string $eventable_id
     * @return response
     */
    public function store($eventable_id)
    {
        if($this->eventValidator->passes()) {
            
            $eventable = $this->eventable->find($eventable_id);
            
            $data = $this->inputAll();
            $data['object'] = $eventable;
 
            if($this->event->setInput($data)->create()) {
            
                $this->message = 'Successfully created event';
                $this->messageType = 'success';
                $this->redirect = action(currentControllerAction('index'), array($eventable->id));
                
            } else {
                
                $this->message = 'There was an error trying to create an event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = action(currentControllerAction('create'), array($eventable->id));
                
            }
            
        } else {
            
            $this->redirect = action(currentControllerAction('create'), array($eventable_id));
            $this->errors = $this->eventValidator->getErrors();
        }
        
        return $this->response();
    }
    
    /**
     * Displays an event
     * 
     * @param string $eventable_id
     * @param string $api_id
     * @return view
     */
    public function show($eventable_id, $api_id)
    {
        $eventable = $this->eventable->find($eventable_id);
        
        $event = $this->event->findByApiId($api_id);
        
        /*
         * Filter recurrences to display entries one month from now
         */
        $filter = array(
            'timeMin' => strToRfc3339(strtotime('now')),
            'timeMax' => strToRfc3339(strtotime('+1 month')),
        );
        
        $recurrences = $this->event->setInput($filter)->getRecurrencesByApiId($api_id);
        
        return view('maintenance::events.show', array(
            'title' => sprintf('Viewing event %s for %s: %s', $event->title, $this->eventableName, $eventable->{$this->eventableNameField}),
            'eventable' => $eventable,
            'event' => $event,
            'recurrences' => $recurrences
        ));
    }
    
    /**
     * Displays a form for editing the event attached to the specified eventable
     * object
     * 
     * @param string $eventable_id
     * @param string $api_id
     * @return view
     */
    public function edit($eventable_id, $api_id)
    {
        $eventable = $this->eventable->find($eventable_id);
        
        $event = $this->event->findByApiId($api_id);
        
        return view('maintenance::events.edit', array(
            'title' => sprintf('Editing event %s for %s: %s', $event->title, $this->eventableName, $eventable->{$this->eventableNameField}),
            'eventable' => $eventable,
            'event' => $event,
        ));
    }
    
    /**
     * Updates the specified event attached to the specified eventable object
     * 
     * @param string $eventable_id
     * @param string $api_id
     * @return response
     */
    public function update($eventable_id, $api_id)
    {
        if($this->eventValidator->passes()) {
            
            $eventable = $this->eventable->find($eventable_id);
            
            $data = $this->inputAll();
            $data['object'] = $eventable;
            
            $event = $this->event->setInput($data)->updateByApiId($api_id);
            
            if($event) {
                
                $this->message = 'Successfully updated event';
                $this->messageType = 'success';
                $this->redirect = action(currentControllerAction('show'), array($eventable->id, $event->id));
                
            } else {
                
                $this->message = 'There was an error trying to udpdate this event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = action(currentControllerAction('edit'), array($eventable->id, $event->id));
                
            }
            
        } else {
            
            $this->redirect = action(currentControllerAction('edit'), array($eventable_id, $api_id));
            $this->errors = $this->eventValidator->getErrors();
            
        }
        
        return $this->response();
    }
    
    /**
     * Deletes the event from the local database as well as the API service
     * 
     * @param string $eventable_id
     * @param string $api_id
     * @return response
     */
    public function destroy($eventable_id, $api_id)
    {
        if($this->event->destroyByApiId($api_id)) {
            
            $this->message = 'Successfully deleted event';
            $this->messageType = 'success';
            $this->redirect = action(currentControllerAction('index'), array($eventable_id));
            
        } else {
            
            $this->message = 'There was an error trying to delete this event. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = action(currentControllerAction('index'), array($eventable_id));
            
        }
        
        return $this->response();
    }
    
}