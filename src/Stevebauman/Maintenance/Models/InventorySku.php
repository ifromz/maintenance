<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Inventory\Traits\InventorySkuTrait;

/**
 * Class InventorySku
 * @package Stevebauman\Maintenance\Models
 */
class InventorySku extends BaseModel
{
    use InventorySkuTrait;

    protected $table = 'inventory_skus';

    protected $fillable = [
        'inventory_id',
        'prefix',
        'code',
    ];

    /**
     * The belongsTo item trait
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\Inventory', 'inventory_id', 'id');
    }
}