<?php namespace Stevebauman\Maintenance\Http\Requests;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

abstract class AbstractRequest {
	
	/**
	 * Stores the URL to redirect to
	 */
	protected $redirect;
	
	/**
	 * Stores the message to display to the user
	 */
	protected $message;
    
	/**
	 * Stores the type of message that is displayed to the user
	 */   
	protected $messageType;
	
	/**
	 * Holds validator errors
	 */  
	protected $errors;
	
	/**
	 * Asks the request if it's ajax or not
	 *
	 * @return Response
	 */
	public function isAjax(){
		return Request::ajax();
	}
	
	/**
	 * Returns the proper response to user. If the request was made from ajax, then an json response is sent.
	 * If a request is a typical request without ajax, a user is sent a redirect with session flash messages
	 *
	 * @return Response
	 */
	public function response(){
		if($this->isAjax()){
			if($this->errors){
				return Response::json(array(
					'errors' => $this->errors,
				));
			} else{
				return Response::json(array(
					'message' => $this->message,
					'messageType' => $this->messageType,
                                        'redirect' => $this->redirect
				));
			}
		} else{
			if($this->errors){
				return Redirect::to($this->redirect)
					->withInput()
					->withErrors($this->errors);
			} else{
				return Redirect::to($this->redirect)
                                        ->withInput()
					->with('message', $this->message)
					->with('messageType', $this->messageType);
			}
		}
	}
	
}