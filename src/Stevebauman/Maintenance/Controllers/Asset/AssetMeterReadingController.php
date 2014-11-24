<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\MeterReadingValidator;
use Stevebauman\Maintenance\Services\MeterReadingService;
use Stevebauman\Maintenance\Services\MeterService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class AssetMeterReadingController extends AbstractController {
    
    public function __construct(
            AssetService $asset, 
            MeterService $meter, 
            MeterReadingService $meterReading, 
            MeterReadingValidator $meterReadingValidator)
    {
        $this->asset = $asset;
        $this->meter = $meter;
        $this->meterReading = $meterReading;
        $this->meterReadingValidator = $meterReadingValidator;
    }
    
    public function store($asset_id, $meter_id)
    {
        if($this->meterReadingValidator->passes()){
            
            $asset = $this->asset->find($asset_id);
            
            $meter = $this->meter->find($meter_id);
            
            $data = $this->inputAll();
            $data['meter_id'] = $meter->id;
            
            
            /*
             * Check if duplicate reading entries are enabled
             */
            if($this->config('maintenance::rules.meters.prevent_duplicate_entries')){
                
                /*
                 * If the last reading is the same as the reading being inputted
                 */
                if($this->input('reading') === $meter->last_reading){
                    
                    /*
                     * Return warning message
                     */
                    $this->message = 'Please enter a reading different from the last reading';
                    $this->messageType = 'warning';
                    $this->redirect = route('maintenance.assets.meters.show', array($asset->id, $meter->id));
                    
                    return $this->response();
                }
                
            }
            
            if($this->meterReading->setInput($data)->create()){
                $this->message = 'Successfully updated reading';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.assets.show', array($asset->id));
            } else{
                $this->message = 'There was an error trying to update this meter. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.assets.show', array($asset->id));
            }
            
        } else{
            $this->errors = $this->meterReadingValidator->getErrors();
        }
        
        return $this->response();
    }
    
    public function destroy($asset_id, $meter_id, $reading_id)
    {
        $asset = $this->asset->find($asset_id);
        
        $meter = $this->meter->find($meter_id);
        
        $this->meterReading->destroy($reading_id);
        
        $this->message = 'Successfully deleted reading';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.assets.meters.show', array($asset->id, $meter->id));
        
        return $this->response();
    }
    
}