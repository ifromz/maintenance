<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\AbstractModelService;
use Stevebauman\Maintenance\Models\Notification;

class NotificationService extends AbstractModelService {
	
	public function __construct(Notification $notification)
        {
            $this->model = $notification;
	}
        
        public function update($id)
        {
            $this->dbStartTransaction();
            
            try {
                
                $notification = $this->find($id);
                
                $insert = array(
                    'read' => $this->getInput('read'),
                );

                if($notification->update($insert)){
                    
                    $this->dbCommitTransaction();
                    
                    return $notification;
                }
                
                $this->dbRollbackTransaction();
                
                return false;
                
            } catch (Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
           
                
        }
	
}