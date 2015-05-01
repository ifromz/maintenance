<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;
use Stevebauman\Inventory\Traits\InventoryStockMovementTrait;

/**
 * Class InventoryStockMovement
 *
 * @package Stevebauman\Maintenance\Models
 */
class InventoryStockMovement extends BaseModel
{
    use InventoryStockMovementTrait;
    use HasUserTrait;

    protected $table = 'inventory_stock_movements';

    /**
     * The fillable eloquent attribute array for allowing mass assignments.
     *
     * @var array
     */
    protected $fillable = [
        'stock_id',
        'user_id',
        'before',
        'after',
        'cost',
        'reason',
    ];

    protected $viewer = 'Stevebauman\Maintenance\Viewers\Inventory\InventoryStockMovementViewer';

    /**
     * The belongsTo stock relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\InventoryStock', 'stock_id', 'id');
    }

    /**
     * Returns the cost of the movement. If no cost is available it will return 0.00.
     *
     * @param $cost
     *
     * @return string
     */
    public function getCostAttribute($cost)
    {
        if ($cost == NULL) {
            return '0.00';
        }

        return $cost;
    }

    /**
     * Returns the change of a stock
     *
     * @return string
     */
    public function getChangeAttribute()
    {
        if ($this->before > $this->after) {

            return sprintf('- %s', $this->before - $this->after);

        } else if($this->after > $this->before) {

            return sprintf('+ %s', $this->after - $this->before);

        } else {
            return 'None';
        }
    }
}
