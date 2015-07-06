<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Viewers\MeterViewer;
use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

class Meter extends BaseModel
{
    use HasUserTrait;

    /**
     * The meter table.
     *
     * @var string
     */
    protected $table = 'meters';

    /**
     * The meter viewer.
     *
     * @var string
     */
    protected $viewer = MeterViewer::class;

    /**
     * The fillable meter attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'metric_id',
        'name',
    ];

    /**
     * The hasOne meter relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function metric()
    {
        return $this->hasOne(Metric::class, 'id', 'metric_id');
    }

    /**
     * The hasMany readings relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function readings()
    {
        return $this->hasMany(MeterReading::class, 'meter_id')->latest();
    }

    /**
     * The belongsToMany assets relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'asset_meters', 'meter_id', 'asset_id')->withTimestamps();
    }

    /**
     * Returns the last reading amount.
     *
     * @return string|null
     */
    public function getLastReadingAttribute()
    {
        $reading = $this->readings->first();

        if ($reading) {
            return $reading->reading;
        }

        return;
    }

    /**
     * Returns the last reading amount with its metric symbol.
     *
     * @return string|null
     */
    public function getLastReadingWithMetricAttribute()
    {
        $reading = $this->readings->first();

        if ($reading) {
            return $reading->reading_with_metric;
        }

        return;
    }

    /**
     * Returns the last reading comment.
     *
     * @return string
     */
    public function getLastCommentAttribute()
    {
        if ($this->readings->count() > 0) {
            return $this->readings->first()->comment;
        }

        return;
    }
}
