<?php namespace Stevebauman\Maintenance\Apis;

use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;
use Stevebauman\Maintenance\Services\NotificationService;
use Stevebauman\Maintenance\Apis\BaseApiController;

class NotificationApi extends BaseApiController {
    
    public function __construct(NotificationService $notification){
        $this->notification = $notification;
    }
    
    public function update($id){
        try{
            
            if($this->notification->update($id)){
                return "Notification successfully updated";
            } else{
                return "There was an error updating this notification. Please try again.";
            }
            
        } catch (RecordNotFoundException $e) {
            return "Notification not found; It either does not exist, or has been deleted.";
        }
    }
    
}