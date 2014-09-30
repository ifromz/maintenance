<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class User extends BaseModel {
	
	protected $table = 'users';
	
	public function getFullNameAttribute(){
            return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
        }
        
        public function getId(){
            return $this->id;
        }
}