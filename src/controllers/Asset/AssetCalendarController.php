<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\CalendarValidator;
use Stevebauman\Maintenance\Services\CalendarService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class AssetCalendarController extends AbstractController {
    
    public function __construct(AssetService $asset, CalendarService $calendar, CalendarValidator $calendarValidator)
    {
        $this->asset = $asset;
        $this->calendar = $calendar;
        $this->calendarValidator = $calendarValidator;
    }
    
    public function index($asset_id)
    {
        $asset = $this->asset->find($asset_id);
        
        return $this->view('maintenance::assets.calendars.index', array(
            'title' => 'Viewing Calendars for Asset: '.$asset->name,
            'asset' => $asset
        ));
    }
    
    public function create($asset_id)
    {
        $asset = $this->asset->find($asset_id);
        
        return $this->view('maintenance::assets.calendars.create', array(
            'title' => 'Creating a Calendar for Asset: '.$asset->name,
            'asset' => $asset
        ));
    }
    
    public function store($asset_id)
    {
        if($this->calendarValidator->passes()) {
            
            $asset = $this->asset->find($asset_id);
            
            $data = $this->inputAll();
            $data['object'] = $asset;
            
            $calendar = $this->calendar->setInput($data)->create();
            
            if($calendar) {
                
                $this->message = 'Successfully created calendar';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.assets.calendars.index', array($asset->id));
                
            } else {
                
                $this->message = 'There was an error trying to create a calendar. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.assets.calendars.create', array($asset->id));
                
            }
            
        } else {
            
            $this->redirect = route('maintenance.assets.calendars.create', array($asset_id));
            $this->errors = $this->calendarValidator->getErrors();
        }
        
        return $this->response();
    }
    
    public function show($asset_id, $calendar_id)
    {
        
    }
    
    public function edit($asset_id, $calendar_id)
    {
        
    }
    
    public function update($asset_id, $calendar_id)
    {
        
    }
    
    public function destroy($asset_id, $calendar_id)
    {
        
    }
    
}