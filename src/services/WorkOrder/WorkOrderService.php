<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\WorkOrderNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\PriorityService;
use Stevebauman\Maintenance\Services\StatusService;
use Stevebauman\Maintenance\Models\WorkOrder;

class WorkOrderService extends AbstractModelService {
	
	public function __construct(
                WorkOrder $workOrder, 
                SentryService $sentry,
                StatusService $status,
                PriorityService $priority,
                WorkOrderNotFoundException $notFoundException
            )
        {
		$this->model = $workOrder;
		$this->sentry = $sentry;
                $this->status = $status;
                $this->priority = $priority;
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
        
        /**
         * Returns an eloquent collection of the current logged in users
         * work orders
         */
        public function getByPageByUser()
        {
            return $this->model->where('user_id', $this->sentry->getCurrentUserId())->paginate(25);
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
		
		if($record = $this->model->create($insert)){
                    
                    if($assets = $this->getInput('assets')){
                        $record->assets()->attach($assets);
                    }
                    
                    $this->fireEvent('maintenance.work-orders.created', array(
                        'workOrder' => $record
                    ));
                    
                    return $record;
		} return false;
	}
	
	public function update($id)
        {

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

                return $record;
            } else{
                return false;
            } 
            
	}
        
        public function createRequest()
        {
            $status = $this->status->firstOrCreateRequest();
            $priority = $this->priority->firstOrCreateRequest();
            
            $insert = array(
                'status_id'     => $status->id,
                'priority_id'   => $priority->id,
                'user_id'       => $this->sentry->getCurrentUserId(),
                'subject'       => $this->getInput('subject', NULL, true),
                'description'   => $this->getInput('description', NULL, true),
            );
            
            $record = $this->model->create($insert);
            
            return $record;
        }
        
        public function updateRequest($id)
        {
            $record = $this->find($id);
            
            $insert = array(
                'subject'       => $this->getInput('subject', $record->subject, true),
                'description'   => $this->getInput('description', $record->description, true)
            );
            
            if($record->update($insert)){
                return $record;
            } else{
                return false;
            }
        }
        
        /**
         * Only allow users to delete their own requests
         * 
         * @param integer $id
         */
        public function destroyRequest($id)
        {
            $record = $this->find($id);
            
            /*
             * Make sure the current logged in User ID equals the work order
             * user id
             */
            if($record->user_id === $this->sentry->getCurrentUserId()){
                $record->delete();
                
                return true;
                
            } else{
                return false;
            }
        }
        
        public function destroy($id) {
            $record = $this->find($id);
            
            $record->delete();
            
            $this->fireEvent('maintenance.work-orders.destroyed', array(
                'workOrder' => $record
            ));
            
            return true;
        }
	
}