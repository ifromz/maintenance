<?php 

/**
 * Handles inventory interactions
 * 
 * @author Steve Bauman <sbauman@bwbc.gc.ca>
 */

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\InventoryNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Inventory;
use Stevebauman\Maintenance\Services\AbstractModelService;

class InventoryService extends AbstractModelService {
    
    public function __construct(Inventory $inventory, SentryService $sentry, InventoryNotFoundException $notFoundException){
        $this->model = $inventory;
        $this->sentry = $sentry;
        $this->notFoundException = $notFoundException;
    }
    
    /**
     * Returns all inventory items paginated, with eager loaded relationships,
     * as well as scopes for search.
     * 
     * @return type Collection
     */
    public function getByPageWithFilter($archived = NULL){
            return $this->model
                    ->with(array(
                            'category',
                            'user',
                            'stocks',
                    ))
                    ->name($this->getInput('name'))
                    ->description($this->getInput('description'))
                    ->category($this->getInput('category'))
                    ->location($this->getInput('location'))
                    ->stock(
                            $this->getInput('operator'),
                            $this->getInput('quantity')
                    )
                    ->archived($archived)
                    ->sort($this->getInput('field'), $this->getInput('sort'))
                    ->paginate(25);
    }
    
    /**
     * Creates an item record
     * 
     * @return boolean OR object
     */
    public function create(){
        
        /*
         * Set input data
         */
        $insert = array(
            'category_id' => $this->getInput('category_id'),
            'user_id' => $this->sentry->getCurrentUserId(),
            'name' => $this->getInput('name', NULL, true),
            'description' => $this->getInput('description', NULL, true),
        );
        
        /*
         * If the record is created, return it, otherwise return false
         */
        if($record = $this->model->create($insert)){
            
            /*
             * Fire created event
             */
            $this->fireEvent('maintenance.inventory.created', array(
                'item' => $record
            ));
            
            return $record;
        } else{
            return false;
        }
        
    }
    
    /**
     * Updates an item record
     * 
     * @param type $id
     * @return boolean
     */
    public function update($id){
        /*
         * Find the item record
         */
        $record = $this->find($id);
            
        /*
         * Set update data
         */
        $insert = array(
            'category_id' => $this->getInput('category_id'),
            'name' => $this->getInput('name', $record->name, true),
            'description' => $this->getInput('description', $record->description, true),
        );

        /*
         * Update the record, return it upon success
         */
        if($record->update($insert)){

            /*
             * Fire updated event
             */
            $this->fireEvent('maintenance.inventory.updated', array(
            '   item' => $record
            ));

            return $record;
        } else{
            return false;
        }
        
    }
    
    /*
     * Archives an item record
     */
    public function destroy($id) {
        $record = $this->find($id);
        
        $record->delete();
        
        /*
         * Fire archived event
         */
        $this->fireEvent('maintenance.inventory.archived', array(
            'item' => $record
        ));
        
        return true;
    }
}