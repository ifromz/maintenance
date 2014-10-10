<?php namespace Stevebauman\Maintenance\Models;

use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

class User extends SentryUser {
	
	protected $table = 'users';
	
	public function getFullNameAttribute(){
            return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
        }
        
        /*
        public function getId(){
            return $this->id;
        }
         * 
         */
}