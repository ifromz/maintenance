<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\AssetEventValidator;
use Stevebauman\Maintenance\Services\EventService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class AssetEventController extends AbstractController {
    
    public function __construct(AssetService $asset, EventService $event, AssetEventValidator $eventValidator) {
        $this->asset = $asset;
        $this->event = $event;
        $this->eventValidator = $eventValidator;
    }
    
    public function index($asset_id){
        $asset = $this->asset->find($asset_id);

        return $this->view('maintenance::assets.events.index', array(
            'title'=>'All Events for '.$asset->name,
            'asset'=>$asset
        ));
    }
    
    public function create($asset_id){
        $asset = $this->asset->find($asset_id);

        return $this->view('maintenance::assets.events.create', array(
            'title'=>'Create an Event for Asset: '.$asset->name,
            'asset'=>$asset,
        ));
    }
    
    public function store($asset_id){
        $validator = new $this->eventValidator;
        
        if($validator->passes()){
            
            $asset = $this->asset->find($asset_id);

            if($record = $this->event->setInput($this->inputAll())->create()){

                $record->assets()->attach($asset);

                $this->message = 'Successfully created schedule';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.assets.events.show', array($asset->id));

            } else{
                $this->message = 'There was an error creating a maintenance schedule for this asset. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.assets.events.create', array($asset->id));
            }
            
        }else{
            $this->errors = $validator->getErrors();
            $this->redirect = route('maintenance.assets.events.create', array($asset_id));
        }
        
        return $this->response();
    }
    
    public function show($asset_id, $event_id){
        
        $asset = $this->asset->find($asset_id);
        $event = $this->event->find($event_id);

        return $this->view('maintenance::assets.events.show', array(
            'title' => sprintf('Viewing Event: %s for Asset: %s', $event->title, $asset->name),
            'asset' => $asset,
            'event' => $event,
        ));
    }
    
    public function edit($asset_id, $event_id){

        $asset = $this->asset->find($asset_id);
        $event = $this->event->find($event_id);

        return $this->view('maintenance::assets.events.edit', array(
            'title' => sprintf('Editing event: %s for Asset: %s', $event->name, $asset->name),
            'asset' => $asset,
            'event' => $event,
        ));
    }
    
    public function update($asset_id, $event_id){

        $asset = $this->asset->find($asset_id);
            
        if($event = $this->event->setInput($this->inputAll())->update($event_id)){
            $this->message = 'Successfully updated event';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.assets.events.show', array($asset->id, $event->id));
        } else{
            $this->message = 'There was an error updating this event. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.assets.events.edit', array($asset->id, $event->id));
        }
        
        return $this->response();
    }
    
    public function destroy($asset_id, $event_id){

        $asset = $this->asset->find($asset_id);

        $this->event->destroy($event_id);

        $this->message = 'Successfully deleted event';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.assets.events.index', array($asset->id));
        
        return $this->response();
        
    }
    
}