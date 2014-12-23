<?php

namespace Stevebauman\Maintenance\Controllers\Event;

use Stevebauman\Maintenance\Validators\Event\EventValidator;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Controllers\BaseController;

class EventController extends BaseController {
    
    public function __construct(EventService $event, EventValidator $eventValidator)
    {
        $this->event = $event;
        $this->eventValidator = $eventValidator;
    }
    
    public function index()
    {
        $events = $this->event->get();
        
        return view('maintenance::events.index', array(
            'title' => 'Events',
            'events' => $events,
        ));
    }
    
    public function create()
    {
        return view('maintenance::events.create', array(
            'title' => 'Create an Event'
        ));
    }
    
    public function store()
    {
        if($this->eventValidator->passes()) {
            
            $event = $this->event->setInput($this->inputAll())->create();
            
            if($event) {
                
                $this->message = sprintf('Successfully created event. %s', link_to_route('maintenance.events.show', 'Show', array($event->id)));
                $this->messageType = 'success';
                $this->redirect = route('maintenance.events.index');
                
            } else {
                
                $this->message = 'There was an error trying to create an event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.events.create');
                
            }
            
        } else {
            
            $this->redirect = route('maintenance.events.create');
            $this->errors = $this->eventValidator->getErrors();
        }
        
        return $this->response();
    }
    
    public function show($api_id)
    {
        $event = $this->event->findByApiId($api_id);
        
        $localEvent = $this->event->findLocalByApiId($api_id);
        
        /*
         * Filter recurrences to display entries one month from now
         */
        $filter = array(
            'timeMin' => strToRfc3339(strtotime('now')),
            'timeMax' => strToRfc3339(strtotime('+1 month')),
        );
        
        $recurrences = $this->event->setInput($filter)->getRecurrencesByApiId($api_id);
        
        return view('maintenance::events.show', array(
            'title' => 'Viewing Event: '.$event->title,
            'event' => $event,
            'localEvent' => $localEvent,
            'recurrences' => $recurrences,
        ));
    }
    
    public function edit($api_id)
    {
        $event = $this->event->findByApiId($api_id);
        
        return view('maintenance::events.edit', array(
            'title' => sprintf('Editing event %s', $event->title),
            'event' => $event,
        ));
    }
    
    public function update($api_id)
    {
        if($this->eventValidator->passes()) {
            
            $event = $this->event->setInput($this->inputAll())->updateByApiId($api_id);
            
            if($event) {
                
                $this->message = 'Successfully updated event';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.events.show', array($event->id));
                
            } else {
                
                $this->message = 'There was an error trying to udpdate this event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.events.edit', array($api_id));
                
            }
            
        } else {
            
            $this->redirect = route('maintenance.events.edit', array($api_id));
            $this->errors = $this->eventValidator->getErrors();
            
        }
        
        return $this->response();
    }
    
    public function destroy($api_id)
    {
        if($this->event->destroyByApiId($api_id)) {
            
            $this->message = 'Successfully deleted event';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.events.index');
            
        } else {
            
            $this->message = 'There was an error trying to delete this event. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.events.show', array($api_id));
            
        }
        
        return $this->response();
    }
    
}