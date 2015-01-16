<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Inventory\Traits\InventoryStockMovementTrait;

/**
 * Class InventoryStockMovement
 * @package Stevebauman\Maintenance\Models\Extended
 */
class InventoryStockMovement extends BaseModel
{

    use InventoryStockMovementTrait;

    protected $table = 'inventory_stock_movements';

    /**
     * The fillable eloquent attribute array for allowing mass assignments
     *
     * @var array
     */
    protected $fillable = array(
        'stock_id',
        'user_id',
        'before',
        'after',
        'cost',
        'reason',
    );

    protected $viewer = 'Stevebauman\Maintenance\Viewers\Inventory\InventoryStockMovementViewer';

    public function getCostAttribute($cost)
    {
        if ($cost == NULL) {
            return '0.00';
        }

        return $cost;
    }

    public function getChangeAttribute()
    {
        if ($this->before > $this->after) {
            return sprintf('- %s', $this->before - $this->after);
        } else {
            return sprintf('+ %s', $this->after - $this->before);
        }
    }

}