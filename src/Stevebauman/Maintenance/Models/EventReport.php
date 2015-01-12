<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class EventReport extends BaseModel
{

    protected $table = 'event_reports';

    protected $fillable = array(
        'event_id',
        'user_id',
        'description',
    );

    public function user()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
    }

}