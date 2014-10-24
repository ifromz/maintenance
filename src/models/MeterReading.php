<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class MeterReading extends BaseModel {
    
    protected $table = 'meter_readings';
    
    protected $fillable = array(
        'user_id',
        'meter_id',
        'reading'
    );
}
