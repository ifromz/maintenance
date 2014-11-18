<?php 

namespace Stevebauman\Maintenance\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

abstract class AbstractController extends Controller {
	
    /**
     * Stores the URL to redirect to
     * 
     * @var string
     */
    protected $redirect;

    /**
     * Stores the message to display to the user
     * 
     * @var string
     */
    protected $message;

    /**
     * Stores the type of message that is displayed to the user
     * 
     * @var string
     */   
    protected $messageType;

    /**
     * Holds validator errors
     * 
     * @var array
     */  
    protected $errors;

    /**
     * Returns a view object. This will render the view to pure HTML if the request is ajax.
     */
    public function view($view, $args = NULL)
    {
        if($this->isAjax()){
            return $this->responseJson(view($view, $args)->render());
        } else{
            return view($view, $args);
        }
    }
    
    /**
     * Returns the given config entry from the Config facade
     * 
     * @param type $entry
     * @return type
     */
    public function config($entry)
    {
        return config($entry);
    }

    /**
     * Asks the request if it's ajax or not
     *
     * @return Request
     */
    public function isAjax()
    {
            return Request::ajax();
    }

    /**
     * Returns the proper response to user. If the request was made from ajax, then an json response is sent.
     * If a request is a typical request without ajax, a user is sent a redirect with session flash messages
     *
     * @return Response
     */
    public function response()
    {            
        if($this->isAjax()){
            if($this->errors){
                return $this->responseJson(array(
                        'errors' => $this->errors,
                ));
            } else{
                return $this->responseJson(array(
                        'message' => $this->message,
                        'messageType' => $this->messageType,
                        'redirect' => $this->redirect
                ));
            }
        } else {
            if($this->errors){
                return redirect($this->redirect)
                        ->withInput()
                        ->withErrors($this->errors);
            } else{
                return redirect($this->redirect)
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
    public function responseJson($data)
    {
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
    protected function input($input, $clean = FALSE)
    {
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
    protected function inputAll()
    {
        return Input::all();
    }
	
}