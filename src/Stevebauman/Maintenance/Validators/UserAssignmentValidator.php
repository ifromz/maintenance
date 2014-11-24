<?php namespace Stevebauman\Maintenance\Validators;

use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Validator;
use Stevebauman\Maintenance\Services\WorkOrderAssignmentService;

class UserAssignmentValidator extends Validator {
    
    protected $invalidUsers = array();
    
    public function __construct($translator, $data, $rules, $messages, WorkOrderAssignmentService $assignment) {
        $this->translator = $translator;
        $this->data = $data;
        $this->rules = $this->explodeRules($rules);
        $this->messages = $messages;
        
        $this->assignment = $assignment;
        
    }
    
    public function validateUserAssignment($attribute, $users, $parameters){
        $workOrder_id = Route::getCurrentRoute()->getParameter('work_orders');
        
        foreach($users as $user){
            $assignment = $this->assignment
                    ->with('toUser')
                    ->where('work_order_id', $workOrder_id)
                    ->where('to_user_id', $user)
                    ->get()
                    ->first();
            
            if($assignment){
               $this->invalidUsers[] = $assignment->toUser->full_name; 
            }
        }
        
        if(count($this->invalidUsers) > 0){
            return false;
        }
        
        return true;
    }
    
    protected function replaceUserAssignment($message, $attribute, $rule, $parameters){
       $message = 'Worker(s): <ul>';
       
        foreach($this->invalidUsers as $user){
            $message .= sprintf('<li>%s</li>', $user);
            
        }
        
        $message .= '</ul> Have already been assigned to this work order. You must remove the assignment before you can re-assign them.';
        return $message;
    }

}