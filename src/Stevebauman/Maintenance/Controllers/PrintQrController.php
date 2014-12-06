<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Controllers\BaseController;

class PrintQrController extends BaseController {
    
    public function generate()
    {
        $qr = $this->input('qr');
        
        if($qr){
            
            return view('maintenance::qr.generate', array(
                'qr' => $qr
            ));
            
        } else{
            $this->redirect = route('maintenance.dashboard.index');
            return $this->response();
        }
    }
    
}