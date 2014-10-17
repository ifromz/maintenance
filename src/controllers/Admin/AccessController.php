<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\AccessCheckValidator;
use Stevebauman\Maintenance\Services\UserService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class AccessController extends AbstractController {
    
    public function __construct(UserService $user, AccessCheckValidator $accessValidator){
        $this->user = $user;
        $this->accessValidator = $accessValidator;
    }
    
    public function postCheck($id){
        
        $validator = new $this->accessValidator;
        
        if($validator->passes()){
        
            $user = $this->user->find($id);
            
            $permission = $this->input('permission');
            
            if($user->hasAccess($permission)){
                $this->message = sprintf('This user <b>has access</b> to %s', $permission);
                $this->messageType = 'success';
                $this->redirect = route('maintenance.admin.users.show', array($user->id));
            } else{
                $this->message = sprintf('This user <b>does not have access</b> to %s', $permission);
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.admin.users.show', array($user->id));
            }
            
        } else{
            $this->errors = $validator->getErrors();
        }
        
        return $this->response();
    }
    
}