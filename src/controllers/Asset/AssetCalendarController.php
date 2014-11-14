<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\CalendarValidator;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class AssetCalendarController extends AbstractController {
    
    public function __construct(AssetService $asset, CalendarValidator $calendarValidator)
    {
        $this->asset = $asset;
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