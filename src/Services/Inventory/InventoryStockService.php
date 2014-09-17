<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\InventoryStock;
use Stevebauman\Maintenance\Services\InventoryStockMovementService;
use Stevebauman\Maintenance\Services\AbstractModelService;

class InventoryStockService extends AbstractModelService {
    
    public function __construct(InventoryStock $inventoryStock, InventoryStockMovementService $inventoryStockMovement){
        parent::__construct();
        $this->model = $inventoryStock;
        $this->inventoryStockMovement = $inventoryStockMovement;
    }
    
    public function create($data){
        $insert = array(
            'inventory_id' => $data['inventory_id'],
            'location_id' => $data['location_id'],
            'quantity' => $data['quantity']
        );
        
        if($record = $this->model->create($insert)){
            
            $movement = array(
                'stock_id' => $record->id,
                'before' => 0,
                'after' => $record->quantity,
                'reason' => 'First Item Record; Stock Increase',
                'cost' => NULL,
            );
            
            //If the inventory movement has been successfully created, return the record. Otherwise delete it.
            if($this->inventoryStockMovement->create($movement)){
                return $record;
            } else{
                $record->delete();
            }
        } return false;
    }
    
    public function update($id, $data){
        if($record = $this->find($id)){
            
            $insert = array(
                'location_id' => $data['location_id'],
                'quantity' => $data['quantity']
            );
            
            $this->db->beginTransaction();
            
            if($record->update($insert)){
                
                $movement = array(
                    'stock_id' => $record->id,
                    'before' => $record->movements->first()->after,
                    'after' => $record->quantity,
                    'reason' => 'Stock Adjustment',
                    'cost' => NULL,
                );
                
                if($this->inventoryStockMovement->create($movement)){
                    $this->db->commit();
                    return $record;
                    
                } else{
                    
                    $this->db->rollback();
                    
                }
                
            } else{
                $this->db->rollback();
            }
            
        } return false;
    }
    
}