<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\LdapService;
use Stevebauman\Maintenance\Models\User;

class UserService {
	
	public function __construct(User $user, SentryService $sentry, LdapService $ldap){
		$this->user = $user;
		$this->sentry = $sentry;
		$this->ldap = $ldap;
	}
	
	/**
     * Create or Update a User for authentication
     *
     * @author Steve Bauman
     *
	 * @param $credentials
     * @return void
     */
	public function createOrUpdateUser($credentials){
		$username = $credentials['username'];
		$password = $credentials['password'];
		
		// If a user is found, update their password to match active-directory
		if($found_user = $this->user->where('username', $username)->first()){
			$this->sentry->updatePasswordById($found_user->id, $password);
		} else{
		// If a user is not found, create their web account
			$fullname = explode(',', $this->ldap->getUserFullName($username));
			$last_name = (array_key_exists(0, $fullname) ? $fullname[0] : NULL);
			$first_name = (array_key_exists(1, $fullname) ? $fullname[1] : NULL);
			
			$data = array(
				'email' => $this->ldap->getUserEmail($username),
				'password' => $password,
                'username' => $username,
                'last_name' => (string)$last_name,
                'first_name' => (string)$first_name,
			);
			
			$this->sentry->createUser($data);
		}
	}
	
}