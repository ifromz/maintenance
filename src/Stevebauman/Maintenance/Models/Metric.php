<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class Metric extends BaseModel
{

    protected $table = 'metrics';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\MetricViewer';

    protected $fillable = array(
        'user_id',
        'name',
        'symbol'
    );

    protected $revisionFormattedFieldNames = array(
        'name' => 'Name',
        'symbol' => 'Symbol',
    );

    /**
     * Allows revisionable to show the metric name instead of ID
     *
     * @return string
     */
    public function identifiableName()
    {
        return $this->name;
    }

    public function user()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
    }

}