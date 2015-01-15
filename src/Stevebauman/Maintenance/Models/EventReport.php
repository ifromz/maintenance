<?php

namespace Stevebauman\Maintenance\Models;


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