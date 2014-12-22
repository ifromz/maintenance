<?php

namespace Stevebauman\Maintenance\Controllers\Event;

use Stevebauman\Maintenance\Validators\EventValidator;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Controllers\BaseController;

class EventController extends BaseController {
    
    public function __construct(
            EventService $event, 
            EventValidator $eventValidator, 
            AssetService $asset, 
            InventoryService $inventory,
            WorkOrderService $workOrder)
    {
        $this->event = $event;
        $this->eventValidator = $eventValidator;
        
        $this->asset = $asset;
        $this->inventory = $inventory;
        $this->workOrder = $workOrder;
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
            
            $data = $this->inputAll();
            $data['objects'] = $this->getAttachableObjects();
            
            if($this->event->setInput($data)->create()) {
                
                $this->message = 'Successfully created event';
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
        
        $tags = $this->event->getTags($api_id);
        
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
            'recurrences' => $recurrences,
            'tags' => $tags,
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
            
            $eventable = $this->eventable->find($eventable_id);
            
            $data = $this->inputAll();
            $data['objects'] = $this->getAttachableObjects();
            
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
            
            $this->redirect = route('maintenance.events.edit', array($api_id));
            $this->errors = $this->eventValidator->getErrors();
            
        }
        
        return $this->response();
    }
    
    public function destroy()
    {
        if($this->event->destroyByApiId($api_id)) {
            
            $this->message = 'Successfully deleted event';
            $this->messageType = 'success';
            $this->redirect = routeBack('maintenance.events.index');
            
        } else {
            
            $this->message = 'There was an error trying to delete this event. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = routeBack('maintenance.events.show', array($api_id));
            
        }
        
        return $this->response();
    }
    
    /**
     * Returns an array of attachable event objects
     * 
     * @return array
     */
    private function getAttachableObjects()
    {
        $assets = $this->input('assets');
        $inventories = $this->input('inventories');
        $workOrders = $this->input('work_orders');
        
        $objects = array();
        
        if(count($assets) > 0) {
            foreach($assets as $asset_id) {

                $asset = $this->asset->find($asset_id);

                if($asset) {
                    $objects[] = $asset;
                }

            }
        }
        
        if(count($inventories) > 0) {
            foreach($inventories as $inventory_id) {

                $inventory = $this->inventory->find($inventory_id);

                if($inventory) {
                    $objects[] = $inventory;
                }

            }
        }
        
        if(count($workOrders) > 0) {
            foreach($workOrders as $workOrder_id) {

                $workOrder = $this->workOrder->find($workOrder_id);

                if($workOrder) {
                    $objects[] = $workOrder;
                }

            }
        }
        
        return $objects;
        
    }
    
}