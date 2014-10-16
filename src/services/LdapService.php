<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Corp\Facades\Corp;

class LdapService {
	
	/**
     * Authenticate with Corp
     *
     * @author Steve Bauman
     *
	 * @param $username, $password
     * @return boolean
     */
	public function authenticate($username, $password){
		if(Corp::auth($username, $password)){
			return true;
		} return false;
	}
	
	/**
     * Return an LDAP user email address
     *
     * @author Steve Bauman
     *
	 * @param $username
     * @return string or boolean
     */
	public function getUserEmail($username){
		$user = Corp::user($username);
                
                if($user){
                    return $user->email;
		} return false;
	}
	
	/**
     * Return an LDAP user full name
     *
     * @author Steve Bauman
     *
	 * @param $username
     * @return string or boolean
     */
	public function getUserFullName($username){
		$user = Corp::user($username);
                
                if($user){
			return $name;
		} return false;
	}
}