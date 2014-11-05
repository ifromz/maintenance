<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\WorkOrderNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\WorkOrder;

class WorkOrderService extends AbstractModelService {
	
	public function __construct(
                WorkOrder $workOrder, 
                SentryService $sentry,
                WorkOrderNotFoundException $notFoundException
            )
        {
		$this->model = $workOrder;
		$this->sentry = $sentry;
                $this->notFoundException = $notFoundException;
        }
        
        /**
         * Returns an eloquent collection of all work orders
         * 
         * @param boolean $archived
         * @return eloquent collection
         */
	public function getByPageWithFilter($archived = NULL)
        {
            
		return $this->model
			->with(array(
				'category',
				'user',
                                'sessions',
			))
                        ->id($this->getInput('id'))
                        ->priority($this->getInput('priority'))
                        ->subject($this->getInput('subject'))
                        ->description($this->getInput('description'))
                        ->status($this->getInput('status'))
                        ->category($this->getInput('work_order_category_id'))
                        ->sort($this->getInput('field'), $this->getInput('sort'))
                        ->archived($archived)
			->paginate(25);
	}
        
        public function getUserAssignedWorkOrders()
        {
            return $this->model
                    ->with(array(
				'status',
				'category',
				'user',
			))
                        ->assignedUser($this->sentry->getCurrentUserId())
                        ->paginate(25);
        }
        
	public function create()
        {
                $this->dbStartTransaction();
                
                try {
                    
                    $insert = array(
                            'user_id'                   => $this->sentry->getCurrentUserId(),
                            'work_order_category_id'    => $this->getInput('work_order_category_id'),
                            'location_id'               => $this->getInput('location_id'),
                            'status_id'                 => $this->getInput('status'),
                            'priority_id'               => $this->getInput('priority'),
                            'subject'                   => $this->getInput('subject', NULL, true),
                            'description'               => $this->getInput('description', NULL, true),
                            'started_at'                => $this->formatDateWithTime($this->getInput('started_at_date'), $this->getInput('started_at_time')),
                            'completed_at'              => $this->formatDateWithTime($this->getInput('completed_at_date'), $this->getInput('completed_at_time')),
                    );

                    $record = $this->model->create($insert);

                    $assets = $this->getInput('assets');

                    if($assets){
                        $record->assets()->attach($assets);
                    }

                    $this->fireEvent('maintenance.work-orders.created', array(
                        'workOrder' => $record
                    ));
                    
                    $this->dbCommitTransaction();
                    
                    return $record;
                    
                } catch(Exception $e) {
                    
                    $this->dbRollbackTransaction();
                    
                    return false;
                }
	}
        
	public function update($id)
        {
            $this->dbStartTransaction();
            
            try{
                $record = $this->find($id);

                $insert = array(
                    'work_order_category_id'    => $this->getInput('work_order_category_id', $record->work_order_category_id),
                    'location_id'               => $this->getInput('location_id', $record->location_id),
                    'status_id'                 => $this->getInput('status', $record->status->id),
                    'priority_id'               => $this->getInput('priority', $record->priority->id),
                    'subject'                   => $this->getInput('subject', $record->subject, true),
                    'description'               => $this->getInput('description', $record->description, true),
                    'started_at'                => $this->formatDateWithTime($this->getInput('started_at_date'), $this->getInput('started_at_time')),
                    'completed_at'              => $this->formatDateWithTime($this->getInput('completed_at_date'), $this->getInput('completed_at_time')),
                );

                if($record->update($insert)){

                    $assets = $this->getInput('assets');

                    if($assets){
                        $record->assets()->sync($assets);
                    }

                    $this->fireEvent('maintenance.work-orders.updated', array(
                        'workOrder' => $record
                    ));
                    
                    $this->dbCommitTransaction();
                    
                    return $record;
                    
                }
                
                $this->dbRollbackTransaction();
                
                return false;
                
            } catch(Exception $e) {
                $this->dbRollbackTransaction();
                
                return false;
            }
            
	}
        
        public function destroy($id) 
        {
            $this->dbStartTransaction();
            
            try{
                
                $record = $this->find($id);

                $record->delete();

                $this->fireEvent('maintenance.work-orders.destroyed', array(
                    'workOrder' => $record
                ));
                
                $this->dbCommitTransaction();
                
                return true;
                
            } catch(Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
        }
        
        /**
         * Attaches a stock item to a work order as a 'part'
         * 
         * @param object $workOrder
         * @param object $stock
         * @return boolean
         */
        public function savePart($workOrder, $stock)
        {
            
            $this->dbStartTransaction();
            
            try{
                /*
                 * Find if the stock ('part') is already attached to the work order
                 */
                $part = $workOrder->parts->find($stock->id);

                /*
                 * If record exists
                 */
                if($part){

                    /*
                     * Add on the quantity inputted to the existing record quantity
                     */
                    $newQuantity = $part->pivot->quantity + $this->getInput('quantity');

                    /*
                     * Update the existing pivot record
                     */
                    $workOrder->parts()->updateExistingPivot($part->id, array('quantity'=>$newQuantity));

                } else{

                    /*
                     * Part Record does not exist, attach a new record with quantity inputted
                     */
                    $workOrder->parts()->attach($stock->id, array('quantity'=>$this->getInput('quantity')));
                }

                /*
                 * Fire the event for notifications
                 */
                $this->fireEvent('maintenance.work-orders.parts.created', array(
                    'workOrder' => $workOrder,
                    'stock' => $stock,
                ));
                
                $this->dbCommitTransaction();
                
                return true;
            
            } catch(Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
        }
        
        /**
         * Attaches a customer update to the work order pivot table
         * 
         * @param object $workOrder
         * @param object $update
         * @return boolean
         */
        public function saveCustomerUpdate($workOrder, $update)
        {
            $this->dbStartTransaction();
            
            try{
            
                if($workOrder->customerUpdates()->save($update)){

                    $this->fireEvent('maintenance.work-orders.updates.customer.created', array(
                        'workOrder' => $workOrder,
                        'update' => $update
                    ));
                    
                    $this->dbCommitTransaction();
                    
                    return true;
                    
                }
                
                $this->dbRollbackTransaction();
                
                return false;
                
            } catch(Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
        }
        
        /**
         * Attaches a technician update to the work order pivot table
         * 
         * @param object $workOrder
         * @param object $update
         * @return boolean
         */
        public function saveTechnicianUpdate($workOrder, $update)
        {
            $this->dbStartTransaction();
            
            try {
            
                if($workOrder->technicianUpdates()->save($update)){

                    $this->fireEvent('maintenance.work-orders.updates.technician.created', array(
                        'workOrder' => $workOrder,
                        'update' => $update
                    ));
                    
                    $this->dbCommitTransaction();
                    
                    return true;
                }
                
                $this->dbRollbackTransaction();
                
                return false;
            
            } catch(Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
        }
	
}