<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\AbstractModelService;
use Stevebauman\Maintenance\Models\Attachment;

class AttachmentService extends AbstractModelService {
	
	public function __construct(Attachment $attachment)
        {
            $this->model = $attachment;
	}
        
        public function create()
        {
            
            $this->dbStartTransaction();
            
            try {
            
                $record = $this->model->create($this->input);

                return $record;
            
            } catch (Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
        }
	
}