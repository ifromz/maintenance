<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

class EventReport extends Model
{
    use HasUserTrait;

    /**
     * The event reports table.
     *
     * @var string
     */
    protected $table = 'event_reports';

    /**
     * The fillable event report attributes.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'user_id',
        'description',
    ];
}
