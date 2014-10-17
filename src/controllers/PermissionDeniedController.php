<?php

namespace Stevebauman\Maintenance\Controllers;

use Illuminate\Support\Facades\Session;
use Stevebauman\Maintenance\Controllers\AbstractController;

class PermissionDeniedController extends AbstractController {
    
    public function getIndex(){
        if(Session::get('message')) {
            
            return $this->view('maintenance::permission-denied', array(
                'title'=>'Permission Denied'
            ));
            
        } else {
            $this->redirect = route('maintenance.dashboard.index');
            
            return $this->response();
        }
    }
    
}