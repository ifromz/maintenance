<?php namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Corp\Facades\Corp;
use Stevebauman\Maintenance\Services\SentryService;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    
    public function __construct(SentryService $sentry){
        $this->sentry = $sentry;
    }
    
    public function run(){
        $users = Corp::allUsers();
        
        foreach($users as $user){
            
            /*
             * Check configured filters
             */
            if(Config::get('maintenance::site.ldap.user_sync.filters.enabled') === true) {
                
                /*
                 * Get the filters from config
                 */
                $allowedGroups = Config::get('maintenance::site.ldap.user_sync.filters.groups');
                $allowedTypes = Config::get('maintenance::site.ldap.user_sync.filters.types');
                
                /*
                 * Check the returned values and make sure they are arrays and that they are enabled
                 * 
                 * Skip (continue) the user if the user group or type is not found in the set filter
                 */
                if($allowedGroups && is_array($allowedGroups)) {
                    if(!in_array($user['group'], $allowedGroups)){
                        continue;
                    }
                }
                
                if($allowedTypes && is_array($allowedTypes)) {
                    if(!in_array($user['type'], $allowedTypes)){
                        continue;
                    }
                }
            }
            
            if(array_key_exists('username', $user)) {
                
                $email = Corp::userEmail($user['username']);
                
                if($email){
                
                    $data = array(
                        'email'    => $email,
                        'password' => str_random(20),
                        'username' => $user['username'],
                        'last_name' => $user['last_name'],
                        'first_name' => $user['first_name'],
                    );
                    
                    $groups[] = $this->sentry->createOrUpdateGroup($user['group']);
                    $groups[] = $this->sentry->createOrUpdateGroup($user['type']);

                    $this->sentry->createUser($data, $groups);
                    
                }
            }
        }
    }
    
}