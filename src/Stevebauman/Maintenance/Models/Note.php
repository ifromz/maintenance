<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

class Note extends BaseModel
{

    use HasUserTrait;

    protected $table = 'notes';

    protected $fillable = array(
        'user_id',
        'content',
    );

    public function assets()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\Asset', 'noteable')->withTimestamps();
    }

    public function inventories()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\Inventory', 'noteable')->withTimestamps();
    }

    public function workOrders()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\WorkOrder', 'noteable')->withTimestamps();
    }

}