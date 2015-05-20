<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

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

    /**
     * Accessor for retrieving the current meter reading
     * with it's metric symbol. For example: '120.00 Gal'.
     *
     * @return mixed|string
     */
    public function getReadingWithMetricAttribute()
    {
        if ($this->meter && $this->meter->metric) {
            return $this->reading.' '.$this->meter->metric->symbol;
        }

        return $this->reading;
    }
}
