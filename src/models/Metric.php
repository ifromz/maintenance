<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class Metric extends BaseModel {
    
    protected $table = 'metrics';
    
    protected $fillable = array(
        'user_id',
        'name'
    );
    
    protected $revisionFormattedFieldNames = array(
        'name' => 'Name',
    );
    
    /**
     * Allows revisionable to show the metric name instead of ID
     * 
     * @return string
     */
    public function identifiableName()
    {
        return $this->name;
    }
    
    public function user()
        {
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
    
}