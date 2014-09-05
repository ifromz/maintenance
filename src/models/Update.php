<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Update extends Eloquent {
	
	protected $table = 'updates';
	
	protected $fillable = array('user_id', 'content');
        
        public function user(){
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
}