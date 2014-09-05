<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent {
	
	protected $table = 'users';
	
	public function getFullNameAttribute(){
            return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
        }
}