<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

class MeterReading extends BaseModel
{
    use HasUserTrait;

    protected $table = 'meter_readings';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\MeterReadingViewer';

    protected $fillable = [
        'user_id',
        'meter_id',
        'reading',
        'comment',
    ];

    /**
     * The belongsTo meter relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meter()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\Meter', 'meter_id');
    }
}
