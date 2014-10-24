<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\MeterReading;
use Stevebauman\Maintenance\Services\AbstractModelService;

class MeterReadingService extends AbstractModelService {
    
    public function __construct(MeterReading $meterReading, SentryService $sentry)
    {
        $this->model = $meterReading;
        $this->sentry = $sentry;
    }
    
    public function create()
    {
        $insert = array(
            'user_id' => $this->sentry->getCurrentUserId(),
            'meter_id' => $this->getInput('meter_id'),
            'reading' => $this->getInput('reading')
        );
        
        return $this->model->create($insert);
    }
    
    public function update($id)
    {
        $record = $this->find($id);
        
        $insert = array(
            'reading' => $this->getInput('reading')
        );
        
        if($record->update($insert)){
            return $record;
        } else{
            return false;
        }
    }
    
}