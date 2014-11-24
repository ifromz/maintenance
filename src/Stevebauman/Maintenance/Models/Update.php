<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class Update extends BaseModel {
	
	protected $table = 'updates';
	
	protected $fillable = array('user_id', 'content');
        
        public function user(){
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
}