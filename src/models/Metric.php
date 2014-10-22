<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class Metric extends BaseModel {
    
    protected $table = 'metrics';
    
    protected $fillable = array(
        'user_id',
        'name'
    );
    
    public function user()
        {
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
    
}