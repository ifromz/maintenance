<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

/**
 * Class EventReport.
 */
class EventReport extends BaseModel
{
    use HasUserTrait;

    protected $table = 'event_reports';

    protected $fillable = [
        'event_id',
        'user_id',
        'description',
    ];
}
