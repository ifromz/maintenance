<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\WorkOrderNotFoundException;
use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Services\SentryService;

class WorkOrderService extends AbstractModelService {
	
	public function __construct(WorkOrder $workOrder, SentryService $sentry, WorkOrderNotFoundException $notFoundException){
		$this->model = $workOrder;
		$this->sentry = $sentry;
                $this->notFoundException = $notFoundException;
        }
        
	public function getByPageWithFilter(){
            
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
                        ->sort($this->getInput('field'), $this->getInput('sort'))
			->paginate(25);
	}
	
	public function getByPageWithCategoryId($category_id){
		return $this->model
			->with(array(
				'status',
				'updates',
				'category',
				'user',
			))
			->where('work_order_category_id', $category_id)
			->paginate(25);
	}
        
	public function create(){
		$insert = array(
			'user_id'                   => $this->sentry->getCurrentUser()->id,
			'work_order_category_id'    => $this->getInput('work_order_category_id'),
                        'location_id'               => $this->getInput('location_id'),
			'status'                    => $this->getInput('status'),
                        'priority'                  => $this->getInput('priority'),
			'subject'                   => $this->getInput('subject', NULL, true),
			'description'               => $this->getInput('description', NULL, true),
			'started_at'                => $this->formatDateWithTime($this->getInput('started_at_date'), $this->getInput('started_at_time')),
			'completed_at'              => $this->formatDateWithTime($this->getInput('completed_at_date'), $this->getInput('completed_at_time')),
		);
		
		if($record = $this->model->create($insert)){
                    
                    if($assets = $this->getInput('assets')){
                        $record->assets()->attach($assets);
                    }
		
                    return $record;
		} return false;
	}
	
	public function update($id){

		if($record = $this->find($id)){
   
			$insert = array(
                            'work_order_category_id'    => $this->getInput('work_order_category_id', $record->work_order_category_id),
                            'location_id'               => $this->getInput('location_id', $record->location_id),
                            'status'                    => $this->getInput('status', $record->status),
                            'priority'                  => $this->getInput('priority', $record->priority),
                            'subject'                   => $this->getInput('subject', $record->subject, true),
                            'description'               => $this->getInput('description', $record->description, true),
                            'started_at'                => $this->formatDateWithTime($this->getInput('started_at_date'), $this->getInput('started_at_time')),
                            'completed_at'              => $this->formatDateWithTime($this->getInput('completed_at_date'), $this->getInput('completed_at_time')),
                        );
			
			if($record->update($insert)){
                            
                            if($assets = $this->getInput('assets')){
                                $record->assets()->sync($assets);
                            }
                            
                            return $record;
			} return false;
		}
                
	}
	
	
	
}