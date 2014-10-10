<?php namespace Stevebauman\Maintenance\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;

abstract class AbstractController extends Controller {
	
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
         * Returns a view object. This will render the view to pure HTML if the request is ajax.
         */
        public function view($view, $args = NULL){
            if($this->isAjax()){
                return View::make($view, $args)->render();
            } else{
                return View::make($view, $args);
            }
        }
        
        public function config($entry){
            return Config::get($entry);
        }
        
	/**
	 * Asks the request if it's ajax or not
	 *
	 * @return Request
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
            } else {
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
        
        /**
         * Returns a JSON response to the client
         * 
         * @param type $data
         * @return type
         */
        public function responseJson($data){
            return Response::json($data);
        }
        
    /**
     * Returns input from the client. If clean is set to true, the input will be
     * ran through the purifier before it is returned.
     * 
     * @param type $input
     * @param type $clean
     * @return null OR Input
     */
    protected function input($input, $clean = FALSE){
        if(Input::has($input)){
            if($clean){
                return $this->clean(Input::get($input));
            } else{
                return Input::get($input);
            }
        }
        
        return NULL;
    }
    
    /**
     * Returns all input
     * 
     * @return type Array
     */
    protected function inputAll(){
        return Input::all();
    }
	
}