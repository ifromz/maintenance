<?php namespace Stevebauman\Maintenance\Controllers;

use View;
use Validator;
use Redirect;
use Response;
use Request;
use Input;
use Config;
use Stevebauman\Maintenance\Services\UserService;
use Stevebauman\Maintenance\Services\AuthService;
use Stevebauman\Maintenance\Controllers\BaseController;

class AuthController extends BaseController {
	
	public function __construct(UserService $user, AuthService $auth){
		$this->user = $user;
		$this->auth = $auth;
	}
	
	/**
     * Show login form
     *
     * @author Steve Bauman
     *
     * @return \View
     */
	public function getLogin(){
		return View::make('maintenance::login');
	}
	
	/**
     * Log in a user
     *
     * @author Steve Bauman
     *
     * @return void
     */
	public function postLogin(){
		$validator = Validator::make(Input::all(), array('username'=>'required', 'password'=>'required'));
		
		if($validator->passes()){
			
			$credentials = array(
				'username' => Input::get('username'),
				'password' => Input::get('password'),
			);
			
			// Check LDAP Authentication
			if($this->auth->ldapAuthenticate($credentials)){

				// Create or update the web user in case the password has been changed in active directory
				$this->user->createOrUpdateUser($credentials);
				
				// Authenticate with Sentry
				$response = $this->auth->sentryAuthenticate($credentials, Input::get('remember'));
				
				// Check response if authenticated
				if($response['authenticated'] === true){
					if(Request::ajax()){
						return Response::json(array(
							'logged_in' => true,
							'message' => 'Successfully logged in. Redirecting...',
							'messageType' => 'success',
							'redirect' => route('maintenance.dashboard.index'),
						));
					} else{
						return Redirect::route('maintenance.dashboard.index')
							->with('message', 'Successfully logged in')
							->with('messageType', 'success');
					}
				} else{
					// Login has failed, return detailed Sentry response
					if(Request::ajax()){
						return Response::json(array(
							'logged_in' => false,
							'message' => $response['message'],
							'messageType' => 'danger',
						));
					} else{
						return Redirect::route('maintenance.dashboard.index')
							->with('message', $response['message'])
							->with('messageType', 'danger');
					}
				}
			} else{
				$message = 'Username or Password is incorrect';
				$messageType = 'danger';
				
				if(Request::ajax()){
					return Response::json(array(
						'logged_in' => false,
						'message' => $message,
						'messageType' => $messageType,
					));
				} else{
					return Redirect::route('maintenance.login')
						->with('message', $message)
						->with('messageType', $messageType);
				}
			}
		} else{
			if(Request::ajax()){
				return Response::json(array(
					'logged_in' => false,
					'errors' => $validator->messages()->getMessages(),
				));
			} else{
				return Redirect::route('maintenance.login')
					->withErrors($validator)
					->withInput();
			}
		}
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
		$this->auth->sentryLogout();
		return Redirect::route('maintenance.login')
			->with('message', 'Successfully logged out')
			->with('messageType', 'success');
	}
	
	
	
}