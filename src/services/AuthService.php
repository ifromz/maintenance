<?php namespace Stevebauman\Maintenance\Services;

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
		if($this->ldap->authenticate($credentials['username'], $credentials['password'])){
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