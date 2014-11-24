<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class Calendar extends BaseModel {
    
    protected $table = 'calendars';
    
    protected $fillable = array(
        'calendarable_id',
        'calendarable_type',
        'name',
        'description',
    );
    
    public function events()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\CalendarEvent', 'calendar_id');
    }
    
}