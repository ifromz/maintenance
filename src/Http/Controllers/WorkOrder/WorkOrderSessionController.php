<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Stevebauman\Maintenance\Http\Requests\WorkOrderSessionRequest;
use Stevebauman\Maintenance\Http\Controllers\BaseController;

class WorkOrderSessionController extends BaseController {
        
        public function __construct(WorkOrderSessionRequest $session){
            $this->session = $session;
        }
        
        public function postStart($workOrder_id){
            return $this->session->start($workOrder_id);
        }
        
        public function postEnd($workOrder_id, $session_id){
            return $this->session->end($workOrder_id, $session_id);
        }
}
