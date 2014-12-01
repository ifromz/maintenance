<?php 

/**
 * Handles inventory stock movement interactions
 * 
 * @author Steve Bauman <sbauman@bwbc.gc.ca>
 */

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\InventoryStockMovement;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\BaseModelService;

class InventoryStockMovementService extends BaseModelService {
    
    public function __construct(InventoryStockMovement $inventoryStockMovement, SentryService $sentry){
        $this->model = $inventoryStockMovement;
        $this->sentry = $sentry;
    }
    
    public function getByPageWithFilter()
    {
        return $this->model
                ->sort($this->getInput('field'), $this->getInput('sort'))
                ->where('stock_id', $this->getInput('stock_id'))
                ->paginate(25);
    }
    
    public function create()
    {
        
        $this->dbStartTransaction();
        
        try {

            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'stock_id' => $this->getInput('stock_id'),
                'before' => $this->getInput('before'),
                'after' => $this->getInput('after'),
                'cost' => $this->getInput('cost'),
                'reason' => $this->getInput('reason', 'Stock Adjustment', true)
            );
            
            /*
             * Only create a record if the before and after quantity differ
             * if enabled in config
             */
            if(config('maintenance::rules.inventory.prevent_duplicate_movements')) {
            
                if($insert['before'] != $insert['after']){

                    $record = $this->model->create($insert);

                    $this->dbCommitTransaction();

                    return $record;
                    
                } else {

                    /*
                     * Return true if before and after quantity are the same
                     * and prevent duplicate movements is enabled
                     */
                    return true;
                }
                
            } else {
                
                /*
                 * Prevent duplicate movements is disabled, create the record
                 */
                $record = $this->model->create($insert);
                
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