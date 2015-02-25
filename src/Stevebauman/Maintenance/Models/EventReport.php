<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

/**
 * Class EventReport
 * @package Stevebauman\Maintenance\Models
 */
class EventReport extends BaseModel
{
    use HasUserTrait;

    protected $table = 'event_reports';

    protected $fillable = array(
        'event_id',
        'user_id',
        'description',
    );

}