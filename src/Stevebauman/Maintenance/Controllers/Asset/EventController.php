<?php

namespace Stevebauman\Maintenance\Controllers\Asset;

use Stevebauman\Maintenance\Validators\EventValidator;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Controllers\BaseController;

class EventController extends BaseController {
    
    public function __construct(AssetService $asset, EventService $event, EventValidator $eventValidator)
    {
        $this->asset = $asset;
        $this->event = $event;
        $this->eventValidator = $eventValidator;
        
       /*
        * Validate if the end date is before the start date only if all day is not checked
        */
        $this->eventValidator->validator()->sometimes('start_date', 'before:end_date', function($input){
            if($input->all_day) {
                return false;
            }
            return true;
        });
    }
    
    public function index($asset_id)
    {
        $asset = $this->asset->find($asset_id);
        
        $events = $this->event->getFromObject($asset);
        
        return view('maintenance::assets.events.index', array(
            'title' => 'All Events for Asset: '.$asset->name,
            'asset' => $asset,
            'events' => $events,
        ));
    }
    
    public function create($asset_id)
    {
        $asset = $this->asset->find($asset_id);
        
        return view('maintenance::assets.events.create', array(
            'title' => 'Create Event for Asset: '.$asset->name,
            'asset' => $asset,
        ));
    }
    
    public function store($asset_id)
    {   
        if($this->eventValidator->passes()) {
            
            $asset = $this->asset->find($asset_id);
            
            $data = $this->inputAll();
            $data['object'] = $asset;
 
            if($this->event->setInput($data)->create()) {
            
                $this->message = 'Successfully created event';
                $this->messageType = 'success';
                $this->redirect = routeBack('maintenance.assets.events.index', array($asset->id));
                
            } else {
                
                $this->message = 'There was an error trying to create an event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = routeBack('maintenance.assets.events.create', array($asset->id));
                
            }
            
        } else {
            
            $this->redirect = routeBack('maintenance.assets.events.create', array($asset_id));
            $this->errors = $this->eventValidator->getErrors();
        }
        
        return $this->response();
    }
    
    public function show($asset_id, $api_id)
    {
        $asset = $this->asset->find($asset_id);
        
        $event = $this->event->findByApiId($api_id);

        return view('maintenance::assets.events.show', array(
            'title' => 'Viewing Asset Event: '.$event->title,
            'asset' => $asset,
            'event' => $event,
        ));
    }
    
    public function edit($asset_id, $api_id)
    {
        $asset = $this->asset->find($asset_id);
        
        $event = $this->event->findByApiId($api_id);
        
        return view('maintenance::assets.events.edit', array(
            'title' => 'Editing Asset Event: '.$event->title,
            'asset' => $asset,
            'event' => $event,
        ));
    }
    
    public function update($asset_id, $api_id)
    {
        if($this->eventValidator->passes()) {
            
            $asset = $this->asset->find($asset_id);
            
            $data = $this->inputAll();
            $data['object'] = $asset;
 
            if($this->event->setInput($data)->updateByApiId($api_id)) {
                
                $this->message = 'Successfully updated event';
                $this->messageType = 'success';
                $this->redirect = routeBack('maintenance.assets.events.show', array($asset->id, $api_id));
                
            } else {
                
                $this->message = 'There was an error trying to udpdate this event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = routeBack('maintenance.assets.events.edit', array($asset->id, $api_id));
                
            }
            
        } else {
            
            $this->redirect = routeBack('maintenance.assets.events.edit', array($asset_id, $api_id));
            $this->errors = $this->eventValidator->getErrors();
            
        }
        
        return $this->response();
    }
    
    public function destroy($asset_id, $api_id)
    {
        if($this->event->destroyByApiId($api_id)) {
            
            $this->message = 'Successfully deleted event';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.assets.events.index', array($asset_id));
            
        } else {
            
            $this->message = 'There was an error trying to delete this event. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.assets.events.index', array($asset_id));
            
        }
        
        return $this->response();
    }
}