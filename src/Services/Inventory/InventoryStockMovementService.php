<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\InventoryStockMovement;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\AbstractModelService;

class InventoryStockMovementService extends AbstractModelService {
    
    public function __construct(InventoryStockMovement $inventoryStockMovement, SentryService $sentry){
        $this->model = $inventoryStockMovement;
        $this->sentry = $sentry;
    }
    
    public function create($data){
        
        $insert = array(
            'stock_id' => $data['stock_id'],
            'user_id' => $this->sentry->getCurrentUserId(),
            'before' => $data['before'],
            'after' => $data['after'],
            'cost' => $data['cost'],
            'reason' => $data['reason'],
        );
        
        //Only create a record if the before and after quantity differ
        if($insert['before'] != $insert['after']){
            if($record = $this->model->create($data)){
                return $record;
            } else{
                return false;
            }
        } return true;
        
    }
    
}