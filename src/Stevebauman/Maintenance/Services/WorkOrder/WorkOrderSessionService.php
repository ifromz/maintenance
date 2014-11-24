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
            
            $this->dbStartTransaction();
            
            try {

                $insert = array(
                    'user_id' => $this->sentry->getCurrentUser()->id,
                    'work_order_id' => $this->getInput('work_order_id'),
                    'in' => Carbon::now()->toDateTimeString(),
                );
                
                $record = $this->model->create($insert);
                
                $this->dbCommitTransaction();
                
                return $record;
            
            } catch (Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
        }
        
        public function update($id){
            
            $this->dbStartTransaction();
            
            try {
            
                $record = $this->model->find($id);

                $insert = array(
                    'out' => Carbon::now()->toDateTimeString(),
                );

                if($record->update($insert)){
                    
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