<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\AuthLoginValidator;
use Stevebauman\Maintenance\Validators\AuthRegisterValidator;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\UserService;
use Stevebauman\Maintenance\Services\LdapService;
use Stevebauman\Maintenance\Services\AuthService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class AuthController extends AbstractController {
        
        public function __construct(
                AuthLoginValidator $loginValidator, 
                AuthRegisterValidator $registerValidator,
                SentryService $sentry,
                UserService $user,
                AuthService $auth,
                LdapService $ldap
            ){
            
            $this->loginValidator = $loginValidator;
            $this->registerValidator = $registerValidator;
            $this->sentry = $sentry;
            $this->user = $user;
            $this->auth = $auth;
            $this->ldap = $ldap;
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getLogin(){
            
            return $this->view('maintenance::login', array(
                'title' => 'Sign In',
            ));
	}
        
        public function postLogin(){
            
            if($this->loginValidator->passes()){

                $data = $this->inputAll();
                
                if($this->config('maintenance::site.ldap.enabled') === true){
                    //If user exists on active directory

                    if($this->ldap->getUserEmail($data['email'])){

                        //Try authentication
                        if($this->auth->ldapAuthenticate($data)){
                            //If authentication is good, update their web profile incase of a password update in AD
                            $user = $this->user->createOrUpdateUser($data);
                            
                            $data['email'] = $user->email;
                        }
                    }
                }
                
                //Authenticate with sentry
                $response = $this->auth->sentryAuthenticate(
                    array_only($data, array('email', 'password')), 
                    (array_key_exists('remember', $data) ? $data['remember'] : NULL)
                );

                // Check response if authenticated
                if($response['authenticated'] === true){
                    //Login success
                    $this->message = 'Successfully logged in. Redirecting...';
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.dashboard.index');

                } else{
                    //Login failed, return sentry response
                    $this->message = $response['message'];
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.login');
                }
                  
            } else{
                $this->errors = $this->loginValidator->getErrors();
                $this->redirect = route('maintenance.login');
            }
            
            return $this->response();
        }
        
        /**
	 * Show the form for registering
	 *
	 * @return Response
	 */
	public function getRegister(){
            return $this->view('maintenance::register', array(
                'title' => 'Register an Account',
            ));
	}
        
        public function postRegister(){
            
            if($this->registerValidator->passes()){
                
                $data = $this->inputAll();
                $data['username'] = uniqid(); //Randomize username since username is only for LDAP logins
                
                $this->sentry->createUser($data);
                
                $this->message = 'Successfully created account. You can now login.';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.login');
            } else {
                $this->errors = $this->registerValidator->getErrors();
                $this->redirect = route('maintenance.register');
            }
            
            return $this->response();
        }

        public function getLogout(){
            $this->auth->sentryLogout();
            
            $this->message = 'Successfully logged out';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.login');
                    
            return $this->response();
        }
	
}
