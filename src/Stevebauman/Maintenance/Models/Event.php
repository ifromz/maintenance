<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class Event extends BaseModel {
    
    protected $table = 'events';
    
    protected $fillable = array(
        'user_id',
        'parent_id',
        'api_id',
    );
    
    protected $viewer = 'Stevebauman\Maintenance\Viewers\Event\EventViewer';

    public function report()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\EventReport', 'event_id');
    }
    
    public function parentEvent()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\Event', 'parent_id');
    }
    
    public function assets()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\Asset', 'eventable')->withTimestamps();
    }
    
    public function inventories()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\Inventory', 'eventable')->withTimestamps();
    }
    
    public function workOrders()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\WorkOrder', 'eventable')->withTimestamps();
    }
    
}