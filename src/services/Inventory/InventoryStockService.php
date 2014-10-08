<?php 

/**
 * Handles inventory stock interactions
 * 
 * @author Steve Bauman <sbauman@bwbc.gc.ca>
 */

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\InventoryStockNotFoundException;
use Stevebauman\Maintenance\Models\InventoryStock;
use Stevebauman\Maintenance\Services\InventoryStockMovementService;
use Stevebauman\Maintenance\Services\AbstractModelService;

class InventoryStockService extends AbstractModelService {
    
    public function __construct(InventoryStock $inventoryStock, InventoryStockMovementService $inventoryStockMovement, InventoryStockNotFoundException $notFoundException){
        /*
         * Construct Parent for $this->db
         */
        parent::__construct();
        
        $this->model = $inventoryStock;
        $this->inventoryStockMovement = $inventoryStockMovement;
        $this->notFoundException = $notFoundException;
    }
    
    /**
     * Creates a stock record as well as a first record movement
     * 
     * @return boolean OR object
     */
    public function create(){
        
        /*
         * Set insert data
         */
        $insert = array(
            'inventory_id' => $this->getInput('inventory_id'),
            'location_id' => $this->getInput('location_id'),
            'quantity' => $this->getInput('quantity')
        );
        
        /*
         * Create the stock record
         */
        if($record = $this->model->create($insert)){
            
            /*
             * Set first movement data
             */
            $movement = array(
                'stock_id' => $record->id,
                'before' => 0,
                'after' => $record->quantity,
                'reason' => 'First Item Record; Stock Increase',
                'cost' => NULL,
            );
            
            /*
             * If the inventory movement has been successfully created, return the record. 
             * Otherwise delete it.
             */
            if($this->inventoryStockMovement->setInput($movement)->create()){
                return $record;
            } else{
                $record->delete();
            }
        } 
        
        /*
         * Error creating record
         */
        return false;
    }
    
    /**
     * Updates the current stock record and creates a stock movement when it has
     * been updated.
     * 
     * @param type $id
     * @return boolean OR object
     */
    public function update($id){
        
        /*
         * Find the stock record
         */
        if($record = $this->find($id)){
            
            /*
             * Set update data
             */
            $insert = array(
                'location_id' => $this->getInput('location_id', $record->location_id),
                'quantity' => $this->getInput('quantity', $record->quantity),
            );
            
            /*
             * Start a database transaction so it can be rolled back upon failure
             */
            $this->db->beginTransaction();
            
            /*
             * Update the stock record
             */
            if($record->update($insert)){
                
                /*
                 * Create the movement
                 */
                if($this->createUpdateMovement($record)){
                    
                    /*
                     * Commit the changes
                     */
                    $this->db->commit();
                    
                    /*
                     * Return updated stock record
                     */
                    return $record;
                    
                } else{
                    
                    /*
                     * Rollback changes
                     */
                    $this->db->rollback();
                    
                }
                
            } else{
                /*
                 * Rollback changes
                 */
                $this->db->rollback();
            }
            
        } 
        
        /*
         * Stock record not found
         */
        return false;
    }
    
    /**
     * Updates the stock record by taking away the inputted stock by the current stock,
     * effectively processing a "taking from stock" action.
     * 
     * @param type $id
     * @return boolean OR object
     */
    public function take($id){
        
        /*
         * Find the stock record
         */
        if($record = $this->find($id)){
            
            /*
             * Set update data
             */
            $insert = array(
                'quantity' => $record->quantity - $this->getInput('quantity'),
            );
            
            /*
             * Update stock record
             */
            $record->update($insert);
            
            /*
             * Create the movement
             */
            $this->createUpdateMovement($record);
            
            /*
             * Return the  record
             */
            return $record;
            
        } 
        /*
         * Stock record not found
         */
        return false;
    }
    
    /**
     * Updates the stock record by adding the inputted stock to the current stock,
     * effectively processing a "putting into the stock" action.
     * 
     * @param type $id
     * @return boolean OR object
     */
    public function put($id){
        /*
         * Find the stock record
         */
        if($record = $this->find($id)){
            
            /*
             * Set update data
             */
            $insert = array(
                'quantity' => $record->quantity + $this->getInput('quantity'),
            );
            
            /*
             * Update the record
             */
            $record->update($insert);
            
            /*
             * Create the movement
             */
            $this->createUpdateMovement($record);
            
            /*
             * Return the record
             */
            return $record;
            
        } 
        
        /*
         * Stock record not found
         */
        return false;
    }
    
    /**
     * Creates a stock movement record
     * 
     * @param type $record
     * @return boolean
     */
    private function createUpdateMovement($record){
        
        /*
         * Set movement insert data
         */
        $movement = array(
            'stock_id' => $record->id,
            'before' => $record->movements->first()->after,
            'after' => $record->quantity,
            'reason' => $this->getInput('reason', NULL, true),
            'cost' => $this->getInput('cost'),
        );
        
        /*
         * Create the stock movement
         */
        $this->inventoryStockMovement->setInput($movement)->create();

        return true;
    }
    
}