<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

abstract class AbstractException extends \Exception {
    
    protected $message;
    
    protected $messageType;
    
    protected $redirect;
    
    public function response(){
        
        if(Request::ajax()){
            return Response::json(array(
                    'message' => $this->message,
                    'messageType' => $this->messageType,
                    'redirect' => $this->redirect
            ));
        } else{
            return Redirect::to($this->redirect)
                    ->with('message', $this->message)
                    ->with('messageType', $this->messageType);
        }
        
    }
    
    public function getRouteParameter($parameter){
        if($param = Route::getCurrentRoute()->getParameter($parameter)){
            return $param;
        } return false;
    }
    
}