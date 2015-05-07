<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

/**
 * Class Meter
 *
 * @package Stevebauman\Maintenance\Models
 */
class Meter extends BaseModel
{
    use HasUserTrait;

    protected $table = 'meters';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\MeterViewer';

    protected $fillable = [
        'user_id',
        'metric_id',
        'name'
    ];

    /**
     * The hasOne meter relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function metric()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Metric', 'id', 'metric_id');
    }

    /**
     * The hasMany readings relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function readings()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\MeterReading', 'meter_id')->latest();
    }

    /**
     * Returns the last reading amount.
     *
     * @return string|null
     */
    public function getLastReadingAttribute()
    {
        $reading = $this->readings->first();

        if($reading) {
            return $reading->reading;
        }

        return null;
    }

    /**
     * Returns the last reading amount with its metric symbol.
     *
     * @return string|null
     */
    public function getLastReadingWithMetricAttribute()
    {
        $reading = $this->readings->first();

        if($reading) {
            return $reading->reading_with_metric;
        }

        return null;
    }

    /**
     * Returns the last reading comment.
     *
     * @return string
     */
    public function getLastCommentAttribute()
    {
        if ($this->readings->count() > 0) return $this->readings->first()->comment;

        return null;
    }
}
