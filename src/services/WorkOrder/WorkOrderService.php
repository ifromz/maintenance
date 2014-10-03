<?php namespace Stevebauman\Maintenance\Services;

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
                        ->priority($this->input('priority'))
                        ->subject($this->input('subject'))
                        ->description($this->input('description'))
                        ->status($this->input('status'))
                        ->category($this->input('work_order_category_id'))
                        ->assets($this->input('assets'))
                        ->orderBy('created_at', 'DESC')
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
	
	public function getMakes($make = NULL){
		return $this->model
			->select('make')
			->distinct()
			->where('make', 'LIKE', '%'.$make.'%')
			->get();
	}
	
	public function getModels($model = NULL){
		return $this->model
			->distinct()
			->select('model')
			->where('model', 'LIKE', '%'.$model.'%')
			->get();
	}
	
	public function getSerials($serial = NULL){
		return $this->model
			->distinct()
			->select('serial')
			->where('serial', 'LIKE', '%'.$serial.'%')
			->get();
	}
        
	public function create(){
		$insert = array(
			'user_id'                   => $this->sentry->getCurrentUser()->id,
			'work_order_category_id'    => $this->input('work_order_category_id'),
                        'location_id'               => $this->input('location_id'),
			'status'                    => $this->input('status'),
                        'priority'                  => $this->input('priority'),
			'subject'                   => $this->input('subject', true),
			'description'               => $this->input('description', true),
			'started_at'                => $this->formatDateWithTime($this->input('started_at_date'), $this->input('started_at_time')),
			'completed_at'              => $this->formatDateWithTime($this->input('completed_at_date'), $this->input('completed_at_time')),
		);
		
		if($record = $this->model->create($insert)){
                    
                    if($assets = $this->input('assets')){
                        $record->assets()->attach($assets);
                    }
		
                    return $record;
		} return false;
	}
	
	public function update($id){
            
		if($workOrder = $this->find($id)){
                    
			$insert = array(
                            'work_order_category_id'    => $this->input('work_order_category_id'),
                            'location_id'               => $this->input('location_id'),
                            'status'                    => $this->input('status'),
                            'priority'                  => $this->input('priority'),
                            'subject'                   => $this->input('subject', true),
                            'description'               => $this->input('description', true),
                            'started_at'                => $this->formatDateWithTime($this->input('started_at_date'), $this->input('started_at_time')),
                            'completed_at'              => $this->formatDateWithTime($this->input('completed_at_date'), $this->input('completed_at_time')),
                        );
			
			if($workOrder->update($insert)){
                            
                            if($assets = $this->input('assets')){
                                $workOrder->assets()->sync($assets);
                            }
                            
                            return $workOrder;
			} return false;
		}
                
	}
	
	
	
}