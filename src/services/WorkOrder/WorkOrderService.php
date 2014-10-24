<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\WorkOrderNotFoundException;
use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Services\SentryService;

class WorkOrderService extends AbstractModelService {
	
	public function __construct(
                WorkOrder $workOrder, 
                SentryService $sentry, 
                WorkOrderNotFoundException $notFoundException)
        {
		$this->model = $workOrder;
		$this->sentry = $sentry;
                $this->notFoundException = $notFoundException;
        }
        
	public function getByPageWithFilter($archived = NULL)
        {
            
		return $this->model
			->with(array(
				'category',
				'user',
                                'sessions',
			))
                        ->priority($this->getInput('priority'))
                        ->subject($this->getInput('subject'))
                        ->description($this->getInput('description'))
                        ->status($this->getInput('status'))
                        ->category($this->getInput('work_order_category_id'))
                        ->assets($this->getInput('assets'))
                        ->archived($archived)
                        ->sort($this->getInput('field'), $this->getInput('sort'))
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
		$insert = array(
			'user_id'                   => $this->sentry->getCurrentUserId(),
			'work_order_category_id'    => $this->getInput('work_order_category_id'),
                        'location_id'               => $this->getInput('location_id'),
			'status_id'                    => $this->getInput('status'),
                        'priority_id'                  => $this->getInput('priority'),
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
                'status_id'                 => $this->getInput('status', $record->status),
                'priority_id'               => $this->getInput('priority', $record->priority),
                'subject'                   => $this->getInput('subject', $record->subject, true),
                'description'               => $this->getInput('description', $record->description, true),
                'started_at'                => $this->formatDateWithTime($this->getInput('started_at_date'), $this->getInput('started_at_time')),
                'completed_at'              => $this->formatDateWithTime($this->getInput('completed_at_date'), $this->getInput('completed_at_time')),
            );

            if($record->update($insert)){

                if($assets = $this->getInput('assets')){
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
        
        public function destroy($id) {
            $record = $this->find($id);
            
            $record->delete();
            
            $this->fireEvent('maintenance.work-orders.created', array(
                'workOrder' => $record
            ));
            
            return true;
        }
	
}