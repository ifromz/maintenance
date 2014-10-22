<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Controllers\AbstractController;

class PrintQrController extends AbstractController {
    
    public function generate()
    {
        $qr = $this->input('qr');
        
        if($qr){
            
            return $this->view('maintenance::qr.generate', array(
                'qr' => $qr
            ));
            
        } else{
            $this->redirect = route('maintenance.dashboard.index');
            return $this->response();
        }
    }
    
}