<?php

namespace Stevebauman\Maintenance\Controllers;

use Dmyers\Storage\Storage;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Services\WorkOrderAttachmentService;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class WorkOrderAttachmentController extends AbstractController {
	
	public function __construct(WorkOrderService $workOrder, WorkOrderAttachmentService $workOrderAttachment, AttachmentService $attachment){
		$this->workOrder = $workOrder;
		$this->workOrderAttachment = $workOrderAttachment;
                $this->attachment = $attachment;
	}
        public function index($workOrder_id){
            $workOrder = $this->workOrder->find($workOrder_id);
            
            return $this->view('maintenance::work-orders.attachments.index', array(
                'title'=>'Work Order Attachments',
                'workOrder'=>$workOrder
            ));
        }
        
        
        public function create($workOrder_id){
            $workOrder = $this->workOrder->find($workOrder_id);
            
            return $this->view('maintenance::work-orders.attachments.create', array(
                'title'=>'Add Attachments to Work Order',
                'workOrder'=>$workOrder
            ));
        }
        
        public function store($workOrder_id){
            $workOrder = $this->workOrder->find($workOrder_id);
            
            $data = $this->inputAll();
            $data['work_order_id'] = $workOrder->id;
            
            if($this->workOrderAttachment->setInput($data)->create()){
                $this->redirect = route('maintenance.work-orders.attachments.index', array($workOrder->id));
                $this->message = 'Successfully added attachments';
                $this->messageType = 'success';
            } else{
                $this->redirect = route('maintenance.work-orders.attachments.create', array($workOrder->id));
                $this->message = 'There was an error adding images to the asset, please try again';
                $this->messageType = 'danger';
            }

            return $this->response();
	}
        
        public function destroy($workOrder_id, $attachment_id){

            $workOrder = $this->workOrder->find($workOrder_id);
            $attachment = $this->attachment->find($attachment_id);
            
            if(Storage::delete($attachment->file_path.$attachment->file_name)){
                $attachment->delete();

                $this->redirect = route('maintenance.work-orders.attachments.index', array($workOrder->id));
                $this->message = 'Successfully deleted attachment';
                $this->messageType = 'success';

            } else{
                $this->redirect = route('maintenance.work-orders.attachments.index', array($workOrder->id));
                $this->message = 'There was an error deleting the attached file, please try again';
                $this->messageType = 'danger';
            }

            return $this->response();
                    
	}
    
}