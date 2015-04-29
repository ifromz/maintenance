<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

/**
 * Class Meter
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
     * @return mixed
     */
    public function readings()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\MeterReading', 'meter_id')->orderBy('created_at', 'DESC');
    }

    /**
     * Returns the last reading amount
     *
     * @return mixed
     */
    public function getLastReadingAttribute()
    {
        if ($this->readings->count() > 0) return $this->readings->first()->reading;
    }

    /**
     * Returns the last reading comment
     *
     * @return mixed
     */
    public function getLastCommentAttribute()
    {
        if ($this->readings->count() > 0) return $this->readings->first()->comment;
    }

}