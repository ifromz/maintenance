<?php namespace Stevebauman\Maintenance\Requests;

use Request;
use Response;
use Redirect;

abstract class AbstractRequest {
	
	protected $redirect;
	
	protected $message;
	
	protected $messageType;
	
	protected $errors;
	
	public function isAjax(){
		return Request::ajax();
	}
	
	public function response(){
		
		if($this->isAjax()){
			if($this->errors){
				return Response::json(array(
					'errors' => $this->errors,
				));
			} else{
				return Response::json(array(
					'message' => $this->message,
					'messageType' => $this->messageType
				));
			}
		} else{
			if($this->errors){
				return Redirect::to($this->redirect)
					->withInput()
					->withErrors($this->errors);
			} else{
				return Redirect::to($this->redirect)
					->with('message', $this->message)
					->with('messageType', $this->messageType);
			}
		}
	}
	
}