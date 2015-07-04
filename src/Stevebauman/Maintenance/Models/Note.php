<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

class Note extends BaseModel
{
    use HasUserTrait;

    /**
     * The notes table.
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * The fillable note attributes.
     *
     * @var array
     */
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
        return $this->morphedByMany(Asset::class, 'noteable')->withTimestamps();
    }

    /**
     * The morphedByMany assets relationship indicating that inventory items can have notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inventories()
    {
        return $this->morphedByMany(Inventory::class, 'noteable')->withTimestamps();
    }

    /**
     * The morphedByMany assets relationship indicating that work orders can have notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workOrders()
    {
        return $this->morphedByMany(WorkOrder::class, 'noteable')->withTimestamps();
    }
}
