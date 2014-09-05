<?php namespace Stevebauman\Maintenance\Services;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException;

class SentryService {
	
	/**
     * Authenticate with Sentry
     *
     * @author Steve Bauman
     *
	 * @param $credentials, $remember
     * @return Array
     */
	public function authenticate($credentials, $remember = NULL){
		$response = array(
			'authenticated' => false,
			'message' => '',
		);
		
		// Try to log in the user with sentry
		try{
                    Sentry::authenticate($credentials, $remember);
                    $response['authenticated'] = true;
                    // Log in was goood, return authenticated response
                    return $response;
		} catch(WrongPasswordException $e){
                    $response['message'] = 'Username or Password is incorrect.';
		} catch(UserNotActivatedException $e){
                    $response['message'] = 'User has not been activated';
		} catch(UserSuspendedException $e){
                    $response['message'] = 'Your account has been suspended. Please try again later.';
		} catch(UserBannedException $e){
                    $response['message'] = 'Your account has been permanetly banned';
		} catch(UserExistsException $e){
                    $response['message'] = 'Username or Password is incorrect.';
                }
		return $response;
	}
	
	/**
     * Logout with Sentry
     *
     * @author Steve Bauman
     *
     * @return void
     */
	public function logout(){
		Sentry::logout();
	}
	
	/**
     * Create a user through Sentry
     *
     * @author Steve Bauman
     *
	 * @param $data
     * @return void
     */
	public function createUser($data){
		$user = Sentry::getUserProvider()->create(array(
			'email'    => $data['email'],
			'password' => $data['password'],
			'username' => $data['username'],
			'last_name' => $data['last_name'],
			'first_name' => $data['first_name'],
		));
		
		$activationCode = $user->getActivationCode();
		$user->attemptActivation($activationCode);
	}
	
	/**
     * Find a user through Sentry
     *
     * @author Steve Bauman
     *
	 * @param $id
     * @return object or boolean
     */
	public function findUserById($id){
		try{
			$user = Sentry::findUserById($id);
			return $user;
		} catch(UserNotFoundException $e){
			return false;
		}
	}
	
	/**
     * Update a user password through sentry
     *
     * @author Steve Bauman
     *
	 * @param $id, $password
     * @return boolean
     */
	public function updatePasswordById($id, $password){
		$user = $this->findUserById($id);
		$user->password = $password;
		if($user->save()){
			return true;
		} return false;
	}
	
	/**
     * Returns current authenticated user
     *
     * @author Steve Bauman
     *
     * @return object
     */
	public function getCurrentUser(){
		return Sentry::getUser();
	}
	
	
	/**
     * Returns current authenticated users full name
     *
     * @author Steve Bauman
     *
     * @return string
     */
	public function getCurrentUserFullName(){
		$user = Sentry::getUser();
		
		$fullName = sprintf('%s %s', $user->first_name, $user->last_name);
		
		return $fullName;
	}
	
	/**
     * Returns current authenticated user ID
     *
     * @author Steve Bauman
     *
     * @return integer
     */
	public function getCurrentUserId(){
		$user = Sentry::getUser();
		
		return $user->id;
	}
	
}