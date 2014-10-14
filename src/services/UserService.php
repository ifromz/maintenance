<?php 

namespace Stevebauman\Maintenance\Services;

use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\LdapService;
use Stevebauman\Maintenance\Models\User;
use Stevebauman\Maintenance\Services\AbstractModelService;

class UserService extends AbstractModelService {
	
	public function __construct(User $user, SentryService $sentry, LdapService $ldap){
                $this->model = $user;
		$this->sentry = $sentry;
		$this->ldap = $ldap;
	}
        
        public function getByPageWithFilter(){
            return $this->model->paginate(25);
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
            $login_attribute = Config::get('cartalyst/sentry::users.login_attribute');
            $username = $credentials[$login_attribute];
            $password = $credentials['password'];
            
            // If a user is found, update their password to match active-directory
            if($user = $this->model->where('username', $username)->first()){
                $this->sentry->updatePasswordById($user->id, $password);
            } else{
                // If a user is not found, create their web account
                $ldapUser = $this->ldap->user($username);
                
                $fullname = explode(',', $ldapUser->name);
                $last_name = (array_key_exists(0, $fullname) ? $fullname[0] : NULL);
                $first_name = (array_key_exists(1, $fullname) ? $fullname[1] : NULL);

                $data = array(
                        'email' => $ldapUser->email,
                        'password' => $password,
                        'username' => $username,
                        'last_name' => (string)$last_name,
                        'first_name' => (string)$first_name,
                    );

                $user = $this->sentry->createUser($data);
            }
            
            return $user;
	}
	
}