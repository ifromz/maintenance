<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;
use Stevebauman\Maintenance\Traits\Relationships\HasLocationTrait;
use Stevebauman\Inventory\Traits\InventoryStockTrait;

/**
 * Class InventoryStock.
 */
class InventoryStock extends BaseModel
{
    use InventoryStockTrait;
    use HasUserTrait;
    use HasLocationTrait;

    /**
     * The database table to store inventory stock records.
     *
     * @var string
     */
    protected $table = 'inventory_stocks';

    /**
     * The fillable eloquent attribute array for allowing mass assignments.
     *
     * @var array
     */
    protected $fillable = [
        'inventory_id',
        'location_id',
        'quantity',
        'aisle',
        'row',
        'bin',
    ];

    protected $revisionFormattedFieldNames = [
        'location_id' => 'Location',
        'quantity' => 'Quantity',
    ];

    /**
     * The inventory stock viewer class.
     *
     * @var string
     */
    protected $viewer = 'Stevebauman\Maintenance\Viewers\Inventory\InventoryStockViewer';

    /*
    * The belongsTo item relationship.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function item()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\Inventory', 'inventory_id', 'id');
    }

    /**
     * The hasOne location relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Location', 'id', 'location_id');
    }

    /**
     * The hasMany transactions relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\InventoryTransaction', 'stock_id', 'id');
    }

    /**
     * The hasMany movements relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movements()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\InventoryStockMovement', 'stock_id')->latest();
    }

    /**
     * Accessor for viewing the last movement of the stock.
     *
     * @return null|string
     */
    public function getLastMovementAttribute()
    {
        if ($this->movements->count() > 0) {
            $movement = $this->movements->first();

            if ($movement->after > $movement->before) {
                return sprintf('<b>%s</b> (Stock was added - %s) - <b>Reason:</b> %s', $movement->change, $movement->created_at, $movement->reason);
            } elseif ($movement->before > $movement->after) {
                return sprintf('<b>%s</b> (Stock was removed - %s) - <b>Reason:</b> %s', $movement->change, $movement->created_at, $movement->reason);
            } else {
                return sprintf('<b>%s</b> (No Change - %s) - <b>Reason:</b> %s', $movement->change, $movement->created_at, $movement->reason);
            }
        }

        return;
    }

    /**
     * Accessor for viewing the user responsible for the last
     * movement.
     *
     * @return null|string
     */
    public function getLastMovementByAttribute()
    {
        if ($this->movements->count() > 0) {
            $movement = $this->movements->first();

            if ($movement->user) {
                return $movement->user->full_name;
            }
        }

        return;
    }

    /**
     * Accessor for viewing the quantity combined with the item metric.
     *
     * @return string
     */
    public function getQuantityMetricAttribute()
    {
        return $this->attributes['quantity'].' '.$this->item->metric->name;
    }
}
