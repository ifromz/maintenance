<?php namespace Stevebauman\Maintenance\Services;

use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Services\LdapService;
use Stevebauman\Maintenance\Services\SentryService;

class AuthService {
	
	public function __construct(LdapService $ldap, SentryService $sentry){
		$this->ldap = $ldap;
		$this->sentry = $sentry;
	}
	
	/**
     * Authenticate with Ldap
     *
     * @author Steve Bauman
     *
	 * @param $credentials
     * @return boolean
     */
	public function ldapAuthenticate($credentials){
            $login_attribute = Config::get('cartalyst/sentry::users.login_attribute');
            
            if($this->ldap->authenticate($credentials[$login_attribute], $credentials['password'])){
                    return true;
            } return false;
	}
	
	/**
     * Authenticate with Sentry
     *
     * @author Steve Bauman
     *
	 * @param $credentials, $remember
     * @return Array
     */
	public function sentryAuthenticate($credentials, $remember = NULL){
		return $this->sentry->authenticate($credentials, $remember);
	}
	
	/**
     * Logout with Sentry
     *
     * @author Steve Bauman
     *
     * @return void
     */
	public function sentryLogout(){
		$this->sentry->logout();
	}
}