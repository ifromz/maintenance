<?php 

namespace Stevebauman\Maintenance\Services;

use Carbon\Carbon;
use Stevebauman\Maintenance\Models\WorkOrderSession;
use Stevebauman\Maintenance\Services\SentryService;

class WorkOrderSessionService extends AbstractModelService {
	
	public function __construct(WorkOrderSession $session, SentryService $sentry){
		$this->model = $session;
		$this->sentry = $sentry;
	}
        
        public function create(){
            $insert = array(
                'user_id' => $this->sentry->getCurrentUser()->id,
                'work_order_id' => $this->getInput('work_order_id'),
                'in' => Carbon::now()->toDateTimeString(),
            );
            
            if($record = $this->model->create($insert)){
                return $record;
            } return false;
        }
        
        public function update($id){
            if($record = $this->model->find($id)){
                
                $insert = array(
                    'out' => Carbon::now()->toDateTimeString(),
                );
                
                if($record->update($insert)){
                    return $record;
                }
                
            } return false;
        }
}