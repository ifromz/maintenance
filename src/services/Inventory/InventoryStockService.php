<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\InventoryStockNotFoundException;
use Stevebauman\Maintenance\Models\InventoryStock;
use Stevebauman\Maintenance\Services\InventoryStockMovementService;
use Stevebauman\Maintenance\Services\AbstractModelService;

class InventoryStockService extends AbstractModelService {
    
    public function __construct(InventoryStock $inventoryStock, InventoryStockMovementService $inventoryStockMovement, InventoryStockNotFoundException $notFoundException){
        parent::__construct();
        
        $this->model = $inventoryStock;
        $this->inventoryStockMovement = $inventoryStockMovement;
        $this->notFoundException = $notFoundException;
    }
    
    public function create($item_id){
        $insert = array(
            'inventory_id' => $item_id,
            'location_id' => $this->input('location_id'),
            'quantity' => $this->input('quantity')
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
    
    public function update($id){
        if($record = $this->find($id)){
            
            $insert = array(
                'location_id' => $this->input('location_id'),
                'quantity' => $this->input('quantity'),
            );
            
            $this->db->beginTransaction();
            
            if($record->update($insert)){
                
                $movement = array(
                    'stock_id' => $record->id,
                    'before' => $record->movements->first()->after,
                    'after' => $record->quantity,
                    'reason' => $this->input('reason', true),
                    'cost' => $this->input('cost'),
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