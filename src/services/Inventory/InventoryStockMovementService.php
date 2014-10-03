<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\InventoryStockMovement;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\AbstractModelService;

class InventoryStockMovementService extends AbstractModelService {
    
    public function __construct(InventoryStockMovement $inventoryStockMovement, SentryService $sentry){
        $this->model = $inventoryStockMovement;
        $this->sentry = $sentry;
    }
    
    public function getByPageWithFilter($stock_id, $data = array()){
        return $this->model->where('stock_id', $stock_id)->paginate(25);
    }
    
    public function create(){
        
        $insert = array(
            'user_id' => $this->sentry->getCurrentUserId(),
            'stock_id' => $this->getInput('stock_id'),
            'before' => $this->getInput('before'),
            'after' => $this->getInput('after'),
            'cost' => $this->getInput('cost'),
            'reason' => $this->getInput('reason', 'Stock Adjustment', true)
        );

        //Only create a record if the before and after quantity differ
        if($insert['before'] != $insert['after']){
            if($record = $this->model->create($insert)){
                return $record;
            } else{
                return false;
            }
        } return true;
        
    }
    
}