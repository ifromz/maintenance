<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

/**
 * Class Note
 *
 * @package Stevebauman\Maintenance\Models
 */
class Note extends BaseModel
{
    use HasUserTrait;

    protected $table = 'notes';

    protected $fillable = [
        'user_id',
        'content',
    ];

    /**
     * The morphedByMany assets relationship indicating that assets can have notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assets()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\Asset', 'noteable')->withTimestamps();
    }

    /**
     * The morphedByMany assets relationship indicating that inventory items can have notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inventories()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\Inventory', 'noteable')->withTimestamps();
    }

    /**
     * The morphedByMany assets relationship indicating that work orders can have notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workOrders()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\WorkOrder', 'noteable')->withTimestamps();
    }
}
