<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class Meter extends BaseModel {
    
    protected $table = 'meters';
    
    protected $viewer = 'Stevebauman\Maintenance\Viewers\MeterViewer';
    
    protected $fillable = array(
        'user_id',
        'metric_id',
        'name'
    );
    
    public function user()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
    }
    
    public function metric()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Metric', 'id', 'metric_id');
    }
    
    public function readings()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\MeterReading', 'meter_id')->orderBy('created_at', 'DESC');
    }
    
    public function getLastReadingAttribute()
    {
        if($this->readings->count() > 0){
            
            return $this->readings->first()->reading;;
            
        }
    }
    
}