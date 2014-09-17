<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Inventory;
use Stevebauman\Maintenance\Services\AbstractModelService;

class InventoryService extends AbstractModelService {
    
    public function __construct(Inventory $inventory, SentryService $sentry){
        $this->model = $inventory;
        $this->sentry = $sentry;
    }
    
    public function getByPage(){
            return $this->model
                    ->paginate(25);
    }
    
    public function create($data){
        
        $insert = array(
            'category_id' => $data['category_id'],
            'user_id' => $this->sentry->getCurrentUserId(),
            'name' => $this->clean($data['name']),
            'description' => $this->clean($data['description']),
        );
        
        if($record = $this->model->create($insert)){
            return $record;
        } else{
            return false;
        }
        
    }
    
    public function update($id, $data){
        if($record = $this->find($id)){
            
            $insert = array(
                'category_id' => $data['category_id'],
                'name' => $this->clean($data['name']),
                'description' => $this->clean($data['description']),
            );
            
            if($record->update($insert)){
                return $record;
            }
            
        } return false;
    }
}