<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\MeterReadingValidator;
use Stevebauman\Maintenance\Validators\MeterValidator;
use Stevebauman\Maintenance\Services\MeterReadingService;
use Stevebauman\Maintenance\Services\MeterService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class AssetMeterController extends AbstractController {
    
    public function __construct(
            AssetService $asset,
            MeterService $meter, 
            MeterReadingService $meterReading, 
            MeterValidator $meterValidator, 
            MeterReadingValidator $meterReadingValidator)
    {
        $this->asset = $asset;
        $this->meter = $meter;
        $this->meterReading = $meterReading;
        $this->meterValidator = $meterValidator;
        $this->meterReadingValidator = $meterReadingValidator;
    }
    
    public function store($asset_id)
    {
        $validator = new $this->meterValidator;
        
        if($validator->passes()){
            
            /*
             * Find the asset
             */
            $asset = $this->asset->find($asset_id);
            
            /*
             * Create the meter
             */
            $meter = $this->meter->setInput($this->inputAll())->create();
            
            /*
             * If the meter has been created
             */
            if($meter){
                /*
                 * Attach the meter to the asset
                 */
                $asset->meters()->attach($meter);
                
                /*
                 * Set the data for the meter reading
                 */
                $data = $this->inputAll();
                $data['meter_id'] = $meter->id;
                
                /*
                 * Create the meter reading
                 */
                $this->meterReading->setInput($data)->create();
                
                $this->message = 'Successfully created meter reading';
                $this->messageType = 'success';
                $this->redirect = '';
                
            } else{
                $this->message = 'There was an error trying to create a meter for this asset. Please try again';
                $this->messageType = 'danger';
                $this->redirect = '';
            }
            
        } else{
            $this->errors = $validator->getErrors();
        }
        
        return $this->response();
    }
    
    public function update($asset_id, $meter_id)
    {
        $validator = new $this->meterReadingValidator;
        
        if($validator->passes()){
            
            $asset = $this->asset->find($asset_id);
            
            $meter = $this->meter->find($meter_id);
            
            $data = $this->inputAll();
            $data['meter_id'] = $meter->id;
            
            if($this->meterReading->setInput($data)->create()){
                $this->message = 'Successfully updated reading';
                $this->messageType = 'success';
                $this->redirect = 'test';
            } else{
                $this->message = 'There was an error trying to update this meter. Please try again';
                $this->messageType = 'danger';
            }
            
        } else{
            $this->errors = $validator->getErrors();
        }
        
        return $this->response();
    }
    
}