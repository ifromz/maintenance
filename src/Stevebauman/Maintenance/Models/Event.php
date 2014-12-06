<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class Event extends BaseModel {
    
    protected $table = 'events';
    
    protected $fillable = array(
        'user_id',
        'eventable_id',
        'eventable_type',
        'api_id',
    );
    
    public function report()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\EventReport', 'event_id');
    }
    
}