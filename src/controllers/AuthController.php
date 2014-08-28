<?php namespace Stevebauman\Maintenance\Controllers;

use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Requests\AuthRequest;
use Stevebauman\Maintenance\Controllers\BaseController;

class AuthController extends BaseController {
	
    public function __construct(AuthRequest $auth){
        $this->auth = $auth;
    }
	
    /**
     * Show the login form
     *
     * @author Steve Bauman
     *
     * @return \View
     */
    public function getLogin(){
        return $this->auth->getLogin();
    }
    
    /**
     * Show the registration form
     *
     * @author Steve Bauman
     *
     * @return \View
     */
    public function getRegister(){
        return View::make('maintenance::register', array(
            'title' => 'Register an Account',
        ));
    }
    
    /**
     * Show the why do I have to register information page
     *
     * @author Steve Bauman
     *
     * @return \View
     */
    public function getWhyRegister(){
        return View::make('maintenance::why-register', array(
            'title' => 'Why Do I Have to Register?',
        ));
    }
    
    public function postRegister(){
        
    }
	
    /**
     * Process user login
     *
     * @author Steve Bauman
     *
     * @return void
     */
    public function postLogin(){
        return $this->auth->postLogin(Input::all());
    }
	
    /**
     * Logout an authenticated user
     *
     * @author Steve Bauman
     *
	 * @param $credentials
     * @return void
     */
    public function getLogout(){
        return $this->auth->getLogout();
    }
	

}