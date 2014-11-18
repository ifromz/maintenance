<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Calendar;
use Stevebauman\Maintenance\Services\AbstractModelService;

class CalendarService extends AbstractModelService {
    
    public function __construct(Calendar $calendar)
    {
        $this->model = $calendar;
    }
    
    /**
     * Creates a calendar record and attaches it to the specified object
     * 
     * @param object $object
     */
    public function create()
    {
        $this->dbStartTransaction();
        
        try {
            
            $insert = array(
                'calendarable_id' => $this->getInput('object')->id,
                'calendarable_type' => get_class($this->getInput('object')),
                'name' => $this->getInput('name', NULL, true),
                'description' => $this->getInput('description', NULL, true)
            );

            $record = $this->model->create($insert);

            if($record) {

                $this->dbCommitTransaction();

                return $record;
            }
            
            $this->dbRollbackTransaction();
            
            return false;
            
        } catch (Exception $e) {
            
            $this->dbRollbackTransaction();
            
            return false;
        }
    }
    
    /**
     * Updates the specified calendar record
     * 
     * @param integer $id
     * @return boolean OR object
     */
    public function update($id)
    {
        $this->dbStartTransaction();
        
        try {
            
            $record = $this->find($id);
            
            $insert = array(
                'name' => $this->getInput('name', $record->name, true),
                'description' => $this->getInput('description', $record->description, true)
            );
            
            if($record->update($insert)){
                
                $this->dbCommitTransaction();
                
                return $record;
            }
            
            $this->dbRollbackTransaction();
            
            return false;
            
        } catch (Exception $e) {
            
            $this->dbRollbackTransaction();
            
            return false;
        }
    }
    
}